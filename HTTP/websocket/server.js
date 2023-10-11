const express = require('express')
const app = express()
const http = require('http')
const httpServer = http.createServer(app)
const {Server} = require("socket.io")
const io = new Server(httpServer, {
    cors: {
        origin: "*",
        allowedHeaders: ["X-CSRF-TOKEN"],
        credentials: false
    }
})

let users = []

httpServer.listen(7001, () => {
    console.log("Servidor online na porta 7001!")
})

io.use((socket, next) => {
    let auth = socket.handshake.auth
    if (!auth.userID)
        return next(new Error("invalid userID"))

    if (!auth.channel)
        return next(new Error("invalid channel"))

    socket.userID = String(auth.userID)
    socket.channel = String(auth.channel) + '.' + String(auth.userID)
    next()
})

io.on('connection', (socket) => {

    let user = registerUser(socket.id, socket.userID)

    socket.join(socket.channel.split('.'))
    console.log(dateLog() + ': user ' + user.userID + ' connected - rooms:', socket.channel.split('.'))

    socket.on("connect", () => {
        console.log('user ' + user.userID + ' connect')
    })

    socket.on("reconnect", (attempt) => {
        console.log('user ' + user.userID + ' reconnect')
    })

    socket.on("reconnect_attempt", (attempt) => {
        console.log('user ' + user.userID + ' reconnect_attempt')
    })

    socket.on("disconnecting", () => {
        //console.log('user ' + user.userID + ' disconnecting')
    })

    socket.on('disconnect', (reason) => {
        console.log('user ' + user.userID + ' disconnected')
    })

    socket.on("connect_error", (error) => {
        console.log('user ' + user.userID + ' connect_error', error)
    })

})

// app route
app.use(express.urlencoded({extended: true}))

app.post('/', (req, res) => {

    const token = (req.get('x-csrf-token') === 'd7a0ADg7OY0TevtWU1HnDIn4inxDEcfxBbFL14NL')

    console.log(dateLog(), req.get('origin'), token, req.body)
    switch (req.get('origin')) {
        case 'fusions.vivo.com.br':
        case 'mobile.fusions.com.br':
        case 'mobiledev.fusions.com.br':
        case 'mobiletest.fusions.com.br':
        case '10.124.100.202':
        case '192.168.248.184':
        case '10.12.103.25':
        case '177.68.194.80':
        case '127.0.0.1':

            if (token)
                io.to(req.body.channel).emit(req.body.event, req.body)

            break
    }

    res.send();
})

app.get('/user', (req, res) => {
    res.sendFile(__dirname + '/examples/user.html')
})

app.get('/user2', (req, res) => {
    res.sendFile(__dirname + '/examples/user2.html')
})

app.get('/admin', (req, res) => {
    res.sendFile(__dirname + '/examples/admin.html')
})

function registerUser(socketID, userID) {

    let user = users.filter((v) => (v.userID === userID))

    if (user.length === 0)
        users.push({socketID, userID})
    else
        users.filter((v) => {
            if (v.userID === userID)
                v.socketID = socketID

        })

    return {socketID, userID, users}
}

function dateLog() {
    let d = new Date()
    return String(d.getDate()).padStart(2, '0') + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + d.getFullYear() + ' ' + String(d.getHours()).padStart(2, '0') + ":" + String(d.getMinutes()).padStart(2, '0')
}