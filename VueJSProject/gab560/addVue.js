
//actually adding to database and submit button state changes need to be completed
//Vue js file used to take in user input, display errors, and finally submit to database
new Vue({
    el: '#formapp',
    props: {

    },
    data: {
        serial: "",
        rack: "",
        pos: "",
        height: "",
        errorHeight: "This Field is Required",
        errorSerial: "This Field is Required",
        errorRack: "This Field is Required",
        errorPos: "This Field is Required"

    },
    methods: {
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
                            self.errorSerial = this.responseText;
                            self.errorSerial += " Is already in the DB";

                        }
                        else {
                            //message is good;
                            self.errorSerial = "";


                        }

                    }
                };
                xmlhttp.open("GET", "checkDevice.php?serial=" + this.serial, true);
                xmlhttp.send();
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
        validHeight: function () {
            if (!this.height) {
                this.errorHeight = "This Field Is Required";
            }
            else if (isNaN(this.height)) {
                this.errorHeight = "This Field must be a number between 1-30";
            }
            else if (this.height>30 || this.height<1) {
                this.errorHeight = "This Field must be a number between 1-30";
            }
            else {
                this.errorHeight = "";
            }

                   


        }


    },
        computed: {


            isDisabled: function () {
                if (this.errorPos.length == 0 && this.errorRack.length == 0 && this.errorSerial.length == 0 && this.errorHeight.length==0) {
                 
                    return false;
                }
                else {
                   
                    return true;

                }
                    

            }
        }
    

    
});