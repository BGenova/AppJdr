function openNav() {
    document.getElementById("btnOpen").style.display = "none";
    document.getElementById("btnClose").style.display = "block";
    document.getElementById("test").style.display = "block";
    document.getElementById("mySidenav").style.width = "400px";
    document.getElementById("mySidenav").style.height = "500px";
    document.getElementById("main").style.marginRight = "400px";
}

function closeNav() {
    document.getElementById("btnOpen").style.display = "block";
    document.getElementById("btnClose").style.display = "none";
    document.getElementById("test").style.display = "none";
    document.getElementById("mySidenav").style.width = "200px";
    document.getElementById("mySidenav").style.height = "40px";
    document.getElementById("main").style.marginRight = "0";
}

function openNavChat() {
    document.getElementById("btnOpenChat").style.display = "none";
    document.getElementById("btnCloseChat").style.display = "block";
    document.getElementById("test").style.display = "block";
    document.getElementById("mySidenavChat").style.width = "500px";
    document.getElementById("mySidenavChat").style.height = "250px";
    document.getElementById("main").style.marginRight = "400px";
}

function closeNavChat() {
    document.getElementById("btnOpenChat").style.display = "block";
    document.getElementById("btnCloseChat").style.display = "none";
    document.getElementById("test").style.display = "none";
    document.getElementById("mySidenavChat").style.width = "200px";
    document.getElementById("mySidenavChat").style.height = "40px";
    document.getElementById("main").style.marginRight = "0";
}

function openNavDice() {
    document.getElementById("btnOpenDice").style.display = "none";
    document.getElementById("btnCloseDice").style.display = "block";
    document.getElementById("test").style.display = "block";
    document.getElementById("mySidenavDice").style.width = "600px";
    document.getElementById("mySidenavDice").style.height = "90px";
    document.getElementById("main").style.marginLeft = "600px";
}

function closeNavDice() {
    document.getElementById("btnOpenDice").style.display = "block";
    document.getElementById("btnCloseDice").style.display = "none";
    document.getElementById("test").style.display = "none";
    document.getElementById("mySidenavDice").style.width = "200px";
    document.getElementById("mySidenavDice").style.height = "40px";
    document.getElementById("main").style.marginLeft = "0";
}