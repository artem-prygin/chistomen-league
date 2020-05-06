function clock() {
    var d = new Date();
    var month_num = d.getMonth()
    var day = d.getDate();
    var hours = d.getHours();
    var minutes = d.getMinutes();
    var seconds = d.getSeconds();
    var mSeconds = d.getMilliseconds();

    let month= ["января", "февраля", "марта", "апреля", "мая", "июня",
        "июля", "августа", "сентября", "октября", "ноября", "декабря"];

    if (day <= 9) day = "0" + day;
    if (hours <= 9) hours = "0" + hours;
    if (minutes <= 9) minutes = "0" + minutes;
    if (seconds <= 9) seconds = "0" + seconds;
    if (mSeconds < 10) {
        mSeconds = "00" + mSeconds;
    } else if (mSeconds >=10 && mSeconds< 100) {
        mSeconds = "0" + mSeconds;
    }

    let dateTime = "Сегодня " + day + " " + month[month_num] + " " + d.getFullYear() +
        " г.&nbsp;&nbsp;&nbsp;Эталонное время - "+ hours + ":" + minutes + ":" + seconds + ":" + mSeconds;
    if (document.layers) {
        document.layers.doc_time.document.write(date_time);
        document.layers.doc_time.document.close();
    }

    else {
        let docTime = document.querySelectorAll(".doc_time")
        for (let i=0; i<docTime.length; i++) {
            docTime[i].innerHTML = dateTime;
        }
    }
}

setInterval(clock, 1);