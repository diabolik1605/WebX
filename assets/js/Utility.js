var JSON = {};
/*
* function toJsonString(object)
*    returns valid JSON String from object
*    modified from Theodor Zoulias's version:
*    http://trimpath.com/forum/viewtopic.php?id=217
*/
JSON.stringify = (function () {
  return function(o) {
    var UNDEFINED
    switch (typeof o) {
      case 'string': return '"' + encodeJS(o) + '"'
      case 'number': return String(o)
      case 'object': 
        if (o) {
          var a = []
          if (o.constructor == []) {
            for (var i = 0; i < o.length; i++) {
              var json = JSON.stringify(o[i])
              if (json != UNDEFINED) a[a.length] = json
            }
            return '[' + a.join(',') + ']'
          } else if (o.constructor == Date) {
            return 'new Date(' + o.getTime() + ')'
          } else {
            for (var p in o) {
              var json = JSON.stringify(o[p])
              if (json != UNDEFINED) a[a.length] = (/^[A-Za-z_]\w*$/.test(p) ? ('"'+ p + '":') : ('"' + encodeJS(p) + '":')) + json
            }
            return '{' + a.join(',') + '}'
          }
        }
        return 'null'
      case 'boolean'  : return String(o)
      case 'function' : return
      case 'undefined': return 'null'
    }
  }
  
  function encodeJS(s) {
    return (!/[\x00-\x19\'\\]/.test(s)) ? s : s.replace(/([\\'])/g, '\\$1').replace(/\r/g, '\\r').replace(/\n/g, '\\n').replace(/\t/g, '\\t').replace(/[\x00-\x19]/g, '')
  }
})();

/*
* Current JSON parser modified by: Nate McQuay for use with Facebook (FBJS)
* Original parser by: Mike Samuel
* Original code from: http://code.google.com/p/json-sans-eval/
* // Usage:
* // return a js object
* parseJSON(jsonString);
*/
JSON.parse = (function() {
var number  = '(?:-?\\b(?:0|[1-9][0-9]*)(?:\\.[0-9]+)?(?:[eE][+-]?[0-9]+)?\\b)';
var oneChar = '(?:[^\\0-\\x08\\x0a-\\x1f\"\\\\]|\\\\(?:[\"/\\\\bfnrt]|u[0-9A-Fa-f]{4}))';
var string  = '(?:\"' + oneChar + '*\")';
var jsonToken = new RegExp('(?:false|true|null|[\\{\\}\\[\\]]' + '|' + number + '|' + string + ')', 'g');
var escapeSequence = new RegExp('\\\\(?:([^u])|u(.{4}))', 'g');
var escapes = {
    '"': '"',
    '/': '/',
    '\\': '\\',
    'b': '\b',
    'f': '\f',
    'n': '\n',
    'r': '\r',
    't': '\t'
};
function unescapeOne(_, ch, hex) {
    return ch ? escapes[ch] : String.fromCharCode(parseInt(hex, 16));
}
return function (json, opt_reviver) {
    var toks = json.match(jsonToken);
    var result;
    var tok = toks[0];
    if ('{' === tok) {
        result = {};
    } else if ('[' === tok) {
        result = [];
    } else {
        // console.error('unsupported initial json token: ' + tok);
    }
    var key;
    var stack = [result];
    for (var i = 1, n = toks.length; i < n; ++i) {
      tok = toks[i];

      var cont;
      switch (tok.charCodeAt(0)) {
        case 0x22:  // '"'
          tok = tok.substring(1, tok.length - 1);
          if (tok.indexOf('\\') !== -1) {
            tok = tok.replace(escapeSequence, unescapeOne);
          }
          cont = stack[0];
          if (!key) {
            if (cont instanceof Array) {
              key = cont.length;
            } else {
              key = tok || '';
              break;
            }
          }
          cont[key] = tok;
          key = 0;
          break;
        case 0x5b:  // '['
          cont = stack[0];
          stack.unshift(cont[key || cont.length] = []);
          key = 0;
          break;
        case 0x5d:  // ']'
          stack.shift();
          break;
        case 0x66:  // 'f'
          cont = stack[0];
          cont[key || cont.length] = false;
          key = 0;
          break;
        case 0x6e:  // 'n'
          cont = stack[0];
          cont[key || cont.length] = null;
          key = 0;
          break;
        case 0x74:  // 't'
          cont = stack[0];
          cont[key || cont.length] = true;
          key = 0;
          break;
        case 0x7b:  // '{'
          cont = stack[0];
          stack.unshift(cont[key || cont.length] = {});
          key = 0;
          break;
        case 0x7d:  // '}'
          stack.shift();
          break;
        default:  // sign or digit
          cont = stack[0];
          cont[key || cont.length] = +(tok);
          key = 0;
          break;
      }
    }
    if (stack.length) {
        // console.error('Could not fully process json object');
    }
    if (opt_reviver) {
      var walk = function (holder, key) {
        var value = holder[key];
        if (value && typeof value === 'object') {
          var toDelete = null;
          for (var k in value) {
            if (value.hasOwnProperty(k)) {
              var v = walk(value, k);
              if (v !== 0) {
                value[k] = v;
              } else {
                if (!toDelete) { toDelete = []; }
                toDelete.push(k);
              }
            }
          }
          if (toDelete) {
            for (var i = toDelete.length; --i >= 0;) {
              delete value[toDelete[i]];
            }
          }
        }
        return opt_reviver.call(holder, key, value);
      };
      result = walk({ '': result }, '');
    }
    return result;
  };
})();