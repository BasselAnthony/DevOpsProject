const express = require("express");

const app = express();

const request = require('request');
const assert = require('assert');

const mocha = require('mocha');
const describe = mocha.describe;

describe('PHP URL Tests', function() {
  it('should return "hello world" when calling the PHP URL', function(done) {
    request('/http://localhost:8000/', function(error, response, body) {
      assert.equal(body, 'Hello World');
      done();
    });
  });
});

app.get("/", (req, res) => {
    res.send("<h1>Hello World!</h1>");
});

const port = process.env.PORT || 3000;

app.listen(port, () => console.log(`listening on port ${port}`));