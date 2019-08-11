setInterval(GetNewQuote, 6 * 2500);

function LoadMainPage() {
    $("#LoadingSpinner").fadeOut("fast");
    $("#mainPage").fadeIn("slow");
    GetNewQuote();
    getWeightsForAPerson();
}

function SubmitNewWeight() {
    $("#weightReqMessage").text("");
    if (!$("#weight").val()) {
        $("#weightReqMessage").text("Required");
        return;
    }
    var date = new Date($("#weightDate").val());
    var formattedDate = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
    var params = $.param({ Date: formattedDate, Weight: $("#weight").val() });
    $.ajax({
        type: "PUT",
        url: 'api.php?action=addWeight&' + params,
        contentType: 'JSON',
        success: function (response) {
            if (response == 0) {
                getWeightsForAPerson();
                $('#newWeightModal').modal('close');
            }
            else {
                $("#weightReqMessage").text(response);
            }
        }
    });
}

function Logout() {
    if (confirm("Logout?")) {
        $.ajax({
            type: "POST",
            url: 'api.php?action=endSesssion',
            contentType: 'JSON',
            success: function (success) {
                if (success) {
                    $("#mainPage").hide();
                    $("#loginPage").fadeIn();
                    personId = null;
                    chartData = null;
                    chartLabels = null;
                    session = false;
                }
                else {
                    alert("Logout Failed");
                }
            }
        });
    }
}

function Login(username, password) {
    $("#loginValidation").text("");

    if (username && password) {
        var params = $.param({ Username: username, Password: password });
        $.ajax({
            type: "GET",
            url: 'api.php?action=login&' + params,
            contentType: 'JSON',
            success: function (responseId) {
                if (responseId > 0) {
                    personId = responseId;

                    $("#loginPage").fadeOut();
                    $("#regPage").fadeOut()
                    $("#mainPage").fadeIn("slow");

                    GetNewQuote();
                    getWeightsForAPerson();
                    return;
                }
                else {
                    $("#loginValidation").text("Login failed, try again");
                }
            }
        });
    }
    else {
        var params = $.param({ Username: $("#usernameLogin").val(), Password: $("#passwordLogin").val() });
        $.ajax({
            type: "GET",
            url: 'api.php?action=login&' + params,
            contentType: 'JSON',
            success: function (responseId) {
                if (responseId > 0) {
                    personId = responseId;

                    $("#loginPage").fadeOut();
                    $("#regPage").fadeOut()
                    $("#mainPage").fadeIn("slow");

                    GetNewQuote();
                    getWeightsForAPerson();
                    return;
                }
                else {
                    $("#loginValidation").text("Login failed, try again");
                }
            }
        });
    }
}

function CheckForSession() {
    $.ajax({
        type: "GET",
        url: 'api.php?action=sessionCheck',
        contentType: 'JSON',
        success: function (response) {
            if (response > 0) {
                session = true;
                personId = response;
                LoadMainPage();
            }
            else {
                session = false;
                $("#LoadingSpinner").fadeOut("slow", () => {
                    $("#loginPage").fadeIn("slow");
                });
            }
        }
    });
}

$("#regBtn").click(() => {
    $("#loginPage").fadeOut(200, () => {
        $("#regPage").fadeIn();
    });
});

$("#bk2loginBtn").click(() => {
    $("#regPage").fadeOut(200, () => {
        $("#loginPage").fadeIn();
    });
});

$("#completeRegBtn").click(() => {
    var invalid = false;
    $.each($('#regPage input[required]'), function () {
        if ($(this).val().length == 0) {
            $("#" + this.id).blur();
            invalid = true;
        }
        if (this.id == "Username" && $(this).val().length < 6 || this.id == "Password" && $(this).val().length < 6) {
            $("#" + this.id).blur();
            invalid = true;
        }
    });

    if (invalid) return;
    RegisterUser();

});

$("#regPage input[required]").blur((e) => {

    if (e.target.value.length == 0) {
        $("#" + e.target.id + "Validation").text(e.target.id + " is required");
        return;
    }

    if (e.target.id == "Username" && e.target.value.length < 6 || e.target.id == "Password" && e.target.value.length < 6) {
        $("#" + e.target.id + "Validation").text(e.target.id + " must be atleast 6 characters");
        return;
    }

    $("#" + e.target.id + "Validation").text("");
});

function GetNewQuote() {
    $.ajax({
        type: "GET",
        url: 'api.php?action=getQuote',
        contentType: 'JSON',
        success: function (response) {
            response = response.replace(/^\s+|\s+$/g, "");
            response = JSON.parse(response);
            $("#quote").fadeOut(200, () => {
                $("#quoteText").text(response[0].Quote);
                $("#quoteAuthor").text(response[0].Author);
            }).fadeIn();
        }
    });
}

function RegisterUser() {
    var regData = {};

    $.each($('#regPage input'), function () {
        var id = this.id;
        regData[this.id] = $(this).val();
    });

    $.ajax({
        type: "POST",
        url: 'api.php?action=register&' + $.param(regData),
        contentType: 'JSON',
        success: function (response) {
            response = response.replace(/^\s+|\s+$/g, "");
            response = JSON.parse(response);
            Login(response.username, response.password);
        }
    });
}

function getWeightsForAPerson() {
    //session id used to get person on server 
    $.ajax({
        type: "GET",
        url: 'api.php?action=getWeight',
        contentType: 'JSON',
        success: function (response) {
            response = response.replace(/^\s+|\s+$/g, "");
            response = JSON.parse(response);
            chartData = [];
            chartLabels = [];
            $.each(response, (index, value) => {
                chartLabels.push(new Date(value.Date).toLocaleString("en-us", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }));
                chartData.push(value.Weight);
                allWeights.push(Number(value.Weight));
            })
            BuildLineWeightChart();
            BuildBarWeightChart();
            $("#avgWeight").text(GetAvg(allWeights));
        }
    });
}

function GetAvg(weights) {
    if (isNaN(weights[0])) {
        return "";
    }
    const total = weights.reduce((acc, c) => acc + c, 0);
    return total / weights.length;
}

function BuildBarWeightChart() {
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Weight',
                data: chartData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

function BuildLineWeightChart() {
    var ctx2 = document.getElementById('myChart2');
    var myChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Weight',
                data: chartData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        precision: 0
                    }
                }]
            }
        }
    });
}