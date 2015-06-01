/**
 * Created by davidcontavalli on 30/05/15.
 */

function Config() {
}

Config.getEndPoint = function () {

    var hostname = location.hostname;
    var environment;

    if (hostname.indexOf("stage") >= 0) {
        environment = "stage.";
    } else if (hostname.indexOf("dev") >= 0) {
        environment = "dev.";
    } else {
        environment = "";
    }

    return "http://api." + environment + "dream-beach.local"

}
