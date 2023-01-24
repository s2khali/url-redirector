# url-redirector
A simple URL Redirector application in PHP

## Running this locally

**Requires a Redis instance to run**
**Docker instructions are for Windows machines**

Add the following to your local hosts file:
```
127.0.0.1 dev.verylongurl.com
127.0.0.1 dev.short.com
```

Build Docker as usual:
```
docker build -t url-shortener .
```

Run the Docker instance:
```
docker run -it -v ${PWD}/includes:/var/www/includes -v ${PWD}/src:/var/www/html -p 80:80 url-shortener
```
