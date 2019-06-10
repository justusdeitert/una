// https://github.com/bcherny/draggable
// --------------------->
// import Draggable from 'Draggable';
const Draggable = require ('draggable');

let element = document.getElementById('draggable');

if(element) {

    let drag = new Draggable(element);

    // Methods
    drag.set(50, 50);
}

$('#draggable i').click(() => {
    $('#draggable').addClass('hide');
});
