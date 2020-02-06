//
// var width = window.innerWidth;
// var height = window.innerHeight;
// var shadowOffset = 20;
// var tween = null;
// var blockSnapSize = 40;
//
// var stage = new Konva.Stage({
//     container: 'container',
//     width: width,
//     height: height
// });
//
// // Création de la grille
//
// var gridLayer = new Konva.Layer();
// var padding = blockSnapSize;
// console.log(width, padding, width / padding);
// for (var i = 0; i < width / padding; i++) {
//     gridLayer.add(new Konva.Line({
//         points: [Math.round(i * padding) + 0.5, 0, Math.round(i * padding) + 0.5, height],
//         stroke: '#fff',
//         strokeWidth: 0.5,
//     }));
// }
//
// gridLayer.add(new Konva.Line({points: [0, 0, 10, 10]}));
// for (var j = 0; j < height / padding; j++) {
//     gridLayer.add(new Konva.Line({
//         points: [0, Math.round(j * padding), width, Math.round(j * padding)],
//         stroke: '#fff',
//         strokeWidth: 0.5,
//     }));
// }
//
//
// var shadowRectangle = new Konva.Rect({
//     x: 0,
//     y: 0,
//     width: blockSnapSize * 1,
//     height: blockSnapSize * 1,
//     fill: '#FF7B17',
//     opacity: 1,
//     stroke: '#CF6412',
//     strokeWidth: 3,
//     dash: [20, 2]
// });
//
// function newRectangle(x, y, layer, stage) {
//     let rectangle = new Konva.Rect({
//         x: x,
//         y: y,
//         width: blockSnapSize * 1,
//         height: blockSnapSize * 1,
//         fill: '#fff',
//         stroke: '#ddd',
//         strokeWidth: 1,
//         shadowColor: 'black',
//         shadowBlur: 2,
//         shadowOffset: {x: 1, y: 1},
//         shadowOpacity: 0.4,
//         draggable: true
//     });
//     rectangle.on('dragstart', (e) => {
//         shadowRectangle.show();
//         shadowRectangle.moveToTop();
//         rectangle.moveToTop();
//     });
//     rectangle.on('dragend', (e) => {
//         rectangle.position({
//             x: Math.round(rectangle.x() / blockSnapSize) * blockSnapSize,
//             y: Math.round(rectangle.y() / blockSnapSize) * blockSnapSize
//         });
//         stage.batchDraw();
//         shadowRectangle.hide();
//     });
//     rectangle.on('dragmove', (e) => {
//         shadowRectangle.position({
//             x: Math.round(rectangle.x() / blockSnapSize) * blockSnapSize,
//             y: Math.round(rectangle.y() / blockSnapSize) * blockSnapSize
//         });
//         // stage.batchDraw();
//     });
//     layer.add(rectangle);
// }
//
// var layer = new Konva.Layer();
// shadowRectangle.hide();
// layer.add(shadowRectangle);
// newRectangle(blockSnapSize * 1, blockSnapSize * 1, layer, stage);
// newRectangle(blockSnapSize * 1, blockSnapSize * 1, layer, stage);
//
// stage.add(gridLayer);
// stage.add(layer);


var width = window.innerWidth;
var height = window.innerHeight - 25;
var shadowOffset = 20;
var tween = null;
var blockSnapSize = 40;

// first we need Konva core things: stage and layer
var stage = new Konva.Stage({
    container: 'container',
    width: width,
    height: height
});

// Création de la grille

var gridLayer = new Konva.Layer();
var padding = blockSnapSize;

// Vertical Line
console.log(width, padding, width / padding);
for (var i = 0; i < width / padding; i++) {
    gridLayer.add(new Konva.Line({
        points: [Math.round(i * padding) + 0.5, 0, Math.round(i * padding) + 0.5, height],
        stroke: 'white',
        strokeWidth: 1,
    }));
}
// Horizontale Line
gridLayer.add(new Konva.Line({points: [0, 0, 10, 10]}));
for (var j = 0; j < height / padding; j++) {
    gridLayer.add(new Konva.Line({
        points: [0, Math.round(j * padding), width, Math.round(j * padding)],
        stroke: 'red',
        strokeWidth: 1,
    }));
}

var layer = new Konva.Layer();
stage.add(layer);

var rect1 = new Konva.Rect({
    x: 200,
    y: 20,
    width: blockSnapSize * 1,
    height: blockSnapSize * 1,
    fill: 'green',
    stroke: 'black',
    draggable: true,
    strokeWidth: 1
});

rect1.on('mouseover', function() {
    document.body.style.cursor = 'pointer';
});
rect1.on('mouseout', function() {
    document.body.style.cursor = 'default';
});
// add the shape to the layer


// then we are going to draw into special canvas element
var canvas = document.createElement('canvas');
canvas.width = stage.width();
canvas.height = stage.height();

// created canvas we can add to layer as "Konva.Image" element
var image = new Konva.Image({
    image: canvas,
    x: 0,
    y: 0
});

stage.add(gridLayer);
layer.add(rect1);
layer.add(image);
stage.draw();


// Good. Now we need to get access to context element
var context = canvas.getContext('2d');
context.strokeStyle = 'green';
context.lineJoin = 'round';
context.lineWidth = 10;

var isPaint = false;
var lastPointerPosition;
var mode = 'brush';

// now we need to bind some events
// we need to start drawing on mousedown
// and stop drawing on mouseup
image.on('mousedown touchstart', function() {
    isPaint = true;
    lastPointerPosition = stage.getPointerPosition();
});

// will it be better to listen move/end events on the window?

stage.on('mouseup touchend', function() {
    isPaint = false;
});

// and core function - drawing
stage.on('mousemove touchmove', function() {
    if (!isPaint) {
        return;
    }

    if (mode === 'brush') {
        context.globalCompositeOperation = 'source-over';
    }
    if (mode === 'eraser') {
        context.globalCompositeOperation = 'destination-out';
    }
    context.beginPath();

    var localPos = {
        x: lastPointerPosition.x - image.x(),
        y: lastPointerPosition.y - image.y()
    };
    context.moveTo(localPos.x, localPos.y);
    var pos = stage.getPointerPosition();
    localPos = {
        x: pos.x - image.x(),
        y: pos.y - image.y()
    };
    context.lineTo(localPos.x, localPos.y);
    context.closePath();
    context.stroke();

    lastPointerPosition = pos;
    layer.batchDraw();
});

var select = document.getElementById('tool');
select.addEventListener('change', function() {
    mode = select.value;
});
