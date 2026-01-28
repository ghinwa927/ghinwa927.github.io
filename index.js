function login(){
    window.location.href='login.html'
}


function toggleAnswer1() {
    const answerElement = document.getElementById('s1');
    if (answerElement.style.display === "none") {
        answerElement.textContent = "There is none";
        answerElement.style.display = "block";
        answerElement.style.color="black";
    } else {
        answerElement.style.display = "none";
    }
}

function toggleAnswer2() {
    const answerElement = document.getElementById('s2');
    if (answerElement.style.display === "none") {
        answerElement.textContent = "No exchange request will be exccepted after 10 days of reciving the product";
        answerElement.style.display = "block";
        answerElement.style.color="black";
    } else {
        answerElement.style.display = "none";
    }
}

function toggleAnswer3() {
    const answerElement = document.getElementById('s3');
    if (answerElement.style.display === "none") {
        answerElement.textContent = "You Can Place An Order Through Our Website  Our via Watsapp";
        answerElement.style.display = "block";
        answerElement.style.color="black";
    } else {
        answerElement.style.display = "none";
    }
}

function gotomen(){
    window.location.href='Men.html';
}

function gotowomen(){
    window.location.href='women.html';
}

function gotohome(){
    window.location.href='index.html';
}

function menJew() {
    const menu = document.querySelector('.men-hidden');
    menu.classList.toggle('show-menu');
  }

  function gotomenbrace(){
    window.location.href='menbracelet.html';
}

  