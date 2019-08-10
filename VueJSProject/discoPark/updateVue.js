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


        serial: "",
        rack: "",
        pos: "",
        model: "",
        manu: "",
        owner: "",
        group: "",
        errorSerial: "",
        errorRack: "",
        errorPos: ""



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
                        if (responses.length >= 6) {
                            self.serial = responses[0];
                            self.rack = responses[1];
                            self.pos = responses[2];
                            self.model = responses[3];
                            self.manu = responses[4];

                            self.group = responses[5];
                            self.owner = responses[6];
                        }


                    }
                }
            };
            var serial = decodeURIComponent(getQueryVariable("serial"));

            xmlhttp.open("GET", "getDeviceData.php?serial=" + serial, true);
            xmlhttp.send();

        },
        //validates the serial number against database
        validSerial: function () {
            var self = this;
            if (!(this.serial)) {
                //empty field
                this.errorSerial = "This Field is Required";
                return;
            }
            else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    var xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {

                        if (this.responseText) {
                            //error message
                            self.errorSerial = "";
                            ;

                        }
                        else {
                            //serial not found means it cant be updated
                            self.errorSerial = "This Serial Number was not found";


                        }

                    }
                };
                xmlhttp.open("GET", "addDevice.php?serial=" + this.serial, true);
                xmlhttp.send();
            }








        },
        move: function(){
            var value = this.serial;
            if (confirm(this.serial + " Is Selected: Move " + this.serial + " to Archives?")) {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    var xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        //object was moved
                        if (this.responseText == "Moved") {
                            alert("Moved to archive");
                            location.assign("/VueJSProject/archive.php");
                        }
                        else {
                            //object was not moved
                            alert(this.responseText);


                        }

                    }
                };
                xmlhttp.open("GET", "moveToArchive.php?serial=" + value, true);
                xmlhttp.send();

            }

            else {
                alert("Did not move to archive");
            }
  

        },
        validRack: function () {
            var self = this;
            if (!(this.rack)) {
                //empty field
                this.errorRack = "This Field is Required";
                return true;
            }
            else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    var xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {

                        if (this.responseText == "0 results") {
                            //rack is not found

                            self.errorRack = "Rack " + self.rack + " does not exist";
                        }
                        else {
                            //rack found
                            self.errorRack = "";

                        }

                    }
                };
                xmlhttp.open("GET", "getRackInfo.php?rack=" + this.rack, true);
                xmlhttp.send();
            }









        },


        //validates position entered to be reasonable:1-45 and a number
        //needs to check if position is already in use, Some smaller devices do have same position so this might not be needed
        validPos: function () {


            if (!(this.pos)) {
                this.errorPos = "This field is Required";



            }
            else if (this.pos > 45 || this.pos < 1) {

                this.errorPos = "Position Must Be 1-45";


            }

            else if (isNaN(this.pos)) {


                this.errorPos = "This Field Must be a Number";



            }
            else {


                this.errorPos = "";



            }


        },
        update: function () {
            var self = this;
            if (confirm(this.serial + " Is Selected: Update " + this.serial + "?")) {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    var xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        if (this.responseText == "GoodGood" || this.responseText == "GoodBad" || this.responseText == "BadGood") {
                            location.reload();
                            alert("Update Successful");

                        }
                        else {
                            //object was not updated
                            alert("Error Updating Device");


                        }
                        }
                       

                    
                };
                xmlhttp.open("GET", "updateDev.php?serial=" + self.serial + "&rack=" + self.rack + "&pos=" + self.pos + "&model=" + self.model + "&manu=" + self.manu + "&group=" + self.group + "&owner=" + self.owner, true);
                xmlhttp.send();

            }
            else {
                alert("Did not Update");
            }

        }


    },
    computed: {


        isDisabled: function () {
            if (this.errorPos.length == 0 && this.errorRack.length == 0 && this.errorSerial == 0) {

                return false;
            }
            else {

                return true;

            }

        },
        isDisabledSerial: function () {
            if (this.errorSerial.length == 0) {

                return false;
            }
            else {

                return true;

            }


        }
    }








});