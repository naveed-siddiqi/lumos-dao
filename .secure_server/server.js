const https = require('https');
const fs = require('fs');
const httpProxy = require('http-proxy');
const path = require('path');

// Load the SSL certificate and key
const options = {
  key: fs.readFileSync(path.join(__dirname, 'key.pem')),
  cert: fs.readFileSync(path.join(__dirname, 'cert.pem'))
};

// Create a proxy server
const proxy = httpProxy.createProxyServer({ target: 'http://localhost:3000', ws: true });

// Target Next.js server (change the host and port as needed)
const targetServer = 'http://localhost:3000';

// Handle errors
proxy.on('error', (err, req, res) => {
  console.error('Proxy error:', err);
  if (res.writeHead && res.end) {
    res.writeHead(502, { 'Content-Type': 'text/plain' });
    res.end('Bad Gateway');
  }
});

// Create an HTTPS server
const server = https.createServer(options, (req, res) => {
  // Proxy the HTTP request to the target server
  proxy.web(req, res, { target: targetServer });
});

// Listen for the `upgrade` event to handle WebSocket connections
server.on('upgrade', (req, socket, head) => {
  // Proxy the WebSocket request to the target server
  proxy.ws(req, socket, head);
});

// Start the server on port 443
server.listen(443, () => {
  console.log('HTTPS server is running and rerouting traffic (including WebSockets) to the Next.js server...');
});




