class Stopwatch {
    constructor(display, results) {
        this.running = false;
        this.display = display;
        this.results = results;
        this.laps = [];
        this.reset();
        this.print(this.times);
    }
    
    reset() {
        this.times = [ 0, 0, 0 ];
    }
    
    start() {
        if (!this.time) this.time = performance.now();
        if (!this.running) {
            this.running = true;
            requestAnimationFrame(this.step.bind(this));
        }
    }
    
    lap() {
        let times = this.times;
        let li = document.createElement('li');
        li.innerText = this.format(times);
        this.results.appendChild(li);
    }
    
    stop() {
        this.running = false;
        this.time = null;
    }

    restart() {
        if (!this.time) this.time = performance.now();
        if (!this.running) {
            this.running = true;
            requestAnimationFrame(this.step.bind(this));
        }
        this.reset();
        this.stop();
        this.print();
    }
    
    clear() {
        clearChildren(this.results);
    }
    
    step(timestamp) {
        if (!this.running) return;
        this.calculate(timestamp);
        this.time = timestamp;
        this.print();
        requestAnimationFrame(this.step.bind(this));
    }
    
    calculate(timestamp) {
        var diff = timestamp - this.time;
        // Hundredths of a second are 100 ms
        //this.times[2] += diff / 10;
        // Seconds are 100 hundredths of a second
        //if (this.times[2] >= 100) {
        //    this.times[1] += 1;
        //    this.times[2] -= 100;
        //}
        this.times[1] += diff / 1000
        // Minutes are 60 seconds
        if (this.times[1] >= 60) {
            this.times[0] += 1;
            this.times[1] -= 60;
        }
    }
    
    print() {
        i;
        for(i=0; i<this.display.length; i++){
            this.display[i].innerText = this.format(this.times);
        }
    }
    
    format_ini(times) {
        return `\
${pad0(times[0], 2)}:\
${pad0(times[1], 2)}:\
${pad0(Math.floor(times[2]), 2)}`;
    }
  
  format(times) {
        return `\
${pad0(times[0], 2)}:\
${pad0(Math.floor(times[1]), 2)}`;
    }
}



function pad0(value, count) {
    var result = value.toString();
    for (; result.length < count; --count)
        result = '0' + result;
    return result;
}

function clearChildren(node) {
    while (node.lastChild)
        node.removeChild(node.lastChild);
}

var cronometros = document.getElementsByName('crn');
var i;
for(i=0; i<cronometros.length; i++){
    cronometros[i].innerHTML = "<div class='stopwatch_crn'></div><nav class='controls_crn'><a href='#' class='btn btn-primary' onClick='stopwatch.start();'>START</a><a href='#' class='btn btn-primary' onClick='stopwatch.stop();'>STOP</a><a href='#' class='btn btn-primary' onClick='stopwatch.restart();'>RESET</a></nav>";
}


let stopwatch = new Stopwatch(
    document.getElementsByClassName('stopwatch_crn'),
    document.querySelector('.results'));

