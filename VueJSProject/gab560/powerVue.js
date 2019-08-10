function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if (pair[0] == variable) { return pair[1]; }
    }
    return (false);
}
new Vue({
    el: '#formapp',
    data: {
        location: "",
        model: "",
        height: "",
        power: "",
        north:"",
        south: "",
        phase:"",
        aamps: "",
        avolts:"",
        errorHeight: "",
        errorVolt: "",
        errorAmps:""

       



    },
    mounted: function () {
        this.load();
    },
    methods: {
        load: function () {
            var self = this;
            if (window.XMLHttpRequest) {

                var xmlhttp = new XMLHttpRequest();

            }
            else {
                var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    if (!(this.responseText == "")) {
                        var responses = JSON.parse(this.responseText);
                        if (responses.length >= 8) {
                            self.location = responses[0];
                            self.model = responses[1];
                            self.height = responses[2];
                            self.power = responses[3];
                            self.north = responses[4];
                            self.south = responses[5];
                            self.phase = responses[6];
                            self.avolts = responses[7];
                            self.aamps = responses[8];
                        }


                    }
                }
            };
            var rack = decodeURIComponent(getQueryVariable("rack"));

            xmlhttp.open("GET", "getPowerData.php?rack=" + rack, true);
            xmlhttp.send();

        },

        validHeight: function () {
            if (!this.height) {
                this.errorHeight = "This field is required";
                return;
            }
            if (isNaN(this.height)) {
                this.errorHeight = "Height must be a Number";
                return;
            }
            else {
               this.errorHeight = "";
            }
        },
        validVolt: function () {
            if (!this.avolts) {
                this.errorVolt = "This field is required";
                return;
            }
            if (isNaN(this.avolts)) {
                this.errorVolt = "Voltage must be a Number";
                return;
            }
            if (this.avolts < 0 || this.avolts > 1000) {
                this.errorAmps = "Amperage is not reasonable";
                return;
            }
            else {
                this.errorVolt = "";
            }
        },
        validAmp: function () {
            if (!this.aamps) {
                this.errorAmps = "This field is required";
                return;
            }
            if (isNaN(this.aamps)) {
                this.errorAmps = "Amperage must be a Number";
                return;
            }
            if (this.aamps < 0 || this.aamps > 1000)
            {
                this.errorAmps = "Amperage is not reasonable";
                return;
            }
            else {
                this.errorAmps = "";
            }
        },
        update: function () {
            var self = this;
            if (confirm(this.location + " Is Selected: Update " + this.location + "?")) {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    var xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        
                        if (this.responseText == "Good") {
                            alert("Update Successful");
                            location.reload();
                        }
                        else {
                            //object was not updated
                            alert(this.responseText);
                        }
                    }
                };
                xmlhttp.open("GET", "updatePower.php?location=" + self.location + "&model=" + self.model + "&height=" + self.height + "&power=" + self.power + "&north=" + self.north + "&south=" + self.south + "&phase=" + self.phase + "&aamps=" + self.aamps + "&avolts=" + self.avolts, true);
                xmlhttp.send();
               

            }
            else {
                alert("Did not Update");
            }

        }
    },
    computed: {
        isDisabled: function () {
            if (this.errorHeight.length == 0 && this.errorAmps.length == 0 && this.errorVolt.length == 0) {

                return false;
            }
            else {

                return true;

            }
            
        }
    }       
});