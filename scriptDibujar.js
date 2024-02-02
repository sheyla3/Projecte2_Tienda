let canvas, ctx, drawing = true, erasing = false;

window.onload = function () {
    canvas = document.getElementById('signatureCanvas');
    ctx = canvas.getContext('2d');
    
    canvas.addEventListener('mousedown', start);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stop);
    canvas.addEventListener('mouseout', stop);

    startDrawing();
};

function startDrawing() {
    drawing = true;
    erasing = false;
    ctx.strokeStyle = '#000';
    ctx.lineWidth = 2; //  grueso lapiz
}

function startErasing() {
    drawing = false;
    erasing = true;
    ctx.strokeStyle = '#fff';
    ctx.lineWidth = 10; // Se puede cambiar como de grueso es el borrador
}

function start(e) {
    if (drawing || erasing) {
        ctx.beginPath();
        ctx.moveTo(e.clientX - canvas.offsetLeft, e.clientY - canvas.offsetTop);
        canvas.addEventListener('mousemove', draw);
    }
}

function draw(e) {
    if (drawing || erasing) {
        ctx.lineTo(e.clientX - canvas.offsetLeft, e.clientY - canvas.offsetTop);
        ctx.stroke();
    }
}

function stop() {
    if (drawing || erasing) {
        ctx.closePath();
        canvas.removeEventListener('mousemove', draw);
    }
}

function saveSignature() {
    if (drawing || erasing) {
        const imageName = `signature_${Date.now()}.png`;
        const imageData = canvas.toDataURL('image/png');

        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    alert('Firma guardada con éxito!');
                } else {
                    alert('Error al guardar la firma');
                }
            }
        };

        xhr.open('POST', 'index.php?controller=admin&action=guardarFirma', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`imageName=${imageName}&imageData=${encodeURIComponent(imageData)}`);
    }
}