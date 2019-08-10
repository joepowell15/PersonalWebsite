//Vuejs file used to display all Racks owned by a group based on user selection
new Vue({
    el: '#groupInfo',

    data: {
        selected: "",
       


    },
    methods: {
        //gets info from ajax->php call and sets the inner html to a table with the request data
        getInfo: function () {

            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                var xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //actually sets the <p> tag with class "info"
                    document.getElementById("info").innerHTML = this.responseText;

                }
            };
            //url call with group parameter
            xmlhttp.open("GET", "/VueJSProject/gab560/getGroupInfo.php?group=" + this.selected, true);
            xmlhttp.send();
        }




    }

});