//Vuejs file that gets and displays all devices in a rack based on user input
new Vue({
    el: '#rackInfo',
   
    data: {
        selected: "",
       
        

    },
    methods: {

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
                                               
                        document.getElementById("info").innerHTML = this.responseText;

                    }
                };
                xmlhttp.open("GET", "getRackInfo.php?rack=" + this.selected, true);
                xmlhttp.send();
            }
         


        
    }
        
});