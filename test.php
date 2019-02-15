<input type="button" value="testme" onClick="getRoute()"/>

<script>
function getRoute() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        alert(this.responseText);
    }
  };
  xhttp.open("GET", "https://route.api.here.com/routing/7.2/calculateroute.json?app_id={hPffnrZxiUj5DETlzaNi}&app_code={bi1hUbPL9na2_Mzk6ZJSyw}&waypoint0=geo!52.5,13.4&waypoint1=geo!52.5,13.45&mode=fastest;car;traffic:disabled", true);
  xhttp.send();
}
</script>