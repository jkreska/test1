
function addScriptTag( id, src ) {
    var head = document.getElementsByTagName('head')[0];
    var script = document.createElement('script');
    script.id = id;
    script.type = 'text/javascript';
    script.src = src;
    head.appendChild(script);
}

function myPageLoad() {
    var scripts = [
        '/resources/prototype/1.6.0.3/prototype.js',
        '/resources/scripts/justjs_common.js'
    ];
    for (var i=0,size=scripts.length; i < size; ++i) {
        addScriptTag( 'script_'+i, scripts[i] );
    }
}

function addCssLink( url ) {
    var head = document.getElementsByTagName('head')[0];
     var link = document.createElement("link");
                link.type = "text/css";
                link.rel = "stylesheet";
                link.href = url;
                link.media = "screen";
                head.appendChild(link);
}