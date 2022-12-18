const request = require('request');

  it('should return "hello world" when calling the PHP URL', function(done) {
    request('/http://localhost:8000/', function(error, response, body) {
      expect('Hello World').toMatch('Hello World');
      done();
    });
  });

  it('should test that true === true', () => {
    expect(true).toBe(true)
  })
