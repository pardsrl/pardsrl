var express = require('express');
var app = express();

var fs = require('fs');

const TRPL_SAI280   = '/srv/data/trpl.sai280';
const TRMAN_SAI280  = '/srv/data/trman.sai280';
const HSTPL_SAI280  = '/srv/data/hstpl.sai280';
const HSTMAN_SAI280 = '/srv/data/hstman.sai280';

app.get('/sai280/hstpl', function (req, res) {

  fs.readFile(HSTPL_SAI280, 'utf8', function(err, data) {
    if( err ){
      console.log(err)
    }
    else{
      res.json(data);
    }
  });

});

app.listen(5140, function () {
  console.log('Example app listening on port 5140!');
});
