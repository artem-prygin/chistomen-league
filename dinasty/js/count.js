function count(time, id){
    setInterval(function(){
        let now = new Date();
        let setdate = new Date(time);
        let result = now.getTime() - setdate.getTime();
        let years = Math.floor(result/1000/60/60/24/365);
        let months = years ? Math.floor((result/1000/60/60/24/30)%12) : Math.floor(result/1000/60/60/24/30);
        let days = Math.floor((result/1000/60/60/24)%30);
        let hours = Math.floor((result/1000/60/60)%24);
        let minutes = Math.floor((result/1000/60)%60);
        let seconds = Math.floor((result/1000)%60);
        let mSeconds = Math.floor(result%1000);

        let yearEnd, monthsEnd, daysEnd, hoursEnd, minutesEnd, pass;

        if (years%10 == 1 && years != 11) {
            pass = 'Прошел',
            yearEnd = 'год'
        } else if ((years%10 == 2 || years%10 == 3 || years%10 == 4) && years < 11 || years > 14) {
            pass = 'Прошло',
            yearEnd = 'года'
        } else {
            pass = 'Прошло',
            yearEnd = 'лет'
        }

        if (months%10 == 1 && months != 11) {
            monthsEnd = 'месяц'
        } else if ((months%10 == 2 || months%10 == 3 || months%10 == 4) && (months < 11 || months > 14)) {
            monthsEnd = 'месяца'
        } else {
            monthsEnd = 'месяцев'
        }

        if (days%10 == 1 && days != 11) {
            daysEnd = 'день'
        } else if ((days%10 == 2 || days%10 == 3 || days%10 == 4) && (days < 11 || days > 14)) {
            daysEnd = 'дня'
        } else {
            daysEnd = 'дней'
        }

        if (hours%10 == 1 && hours != 11) {
            hoursEnd = 'час'
        } else if ((hours%10 == 2 || hours%10 == 3 || hours%10 == 4) && (hours < 11 || hours > 14)) {
            hoursEnd = 'часа'
        } else {
            hoursEnd = 'часов'
        }

        if (minutes%10 == 1 && minutes != 11) {
            minutesEnd = 'минута'
        } else if ((minutes%10 == 2 || minutes%10 == 3 || minutes%10 == 4) && (minutes < 11 || minutes > 14)) {
            minutesEnd = 'минуты'
        } else {
            minutesEnd = 'минут'
        }

        let passTime = document.querySelector(`[data-time = "${id}"]`);
        passTime.innerHTML = `${pass} ${years} ${yearEnd} ${months} ${monthsEnd} ${days} ${daysEnd} ${hours} ${hoursEnd} ${minutes} ${minutesEnd} ${seconds}:${mSeconds} секунд`;

    }, 1);
}