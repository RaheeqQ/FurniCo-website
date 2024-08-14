const Products2 = [];

document.addEventListener('DOMContentLoaded', () => {
    // Assuming you have an array of products
    fetch('products.php')
        .then(resonse => resonse.json())
        .then(data => {
            window.Products2 = data;

            // Get product information from query parameter
            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get('productId');

            // Check if the productId is valid
            if ( productId > 0) {
                const product = window.Products2[productId - 1];
                // Update page content with product information
                document.getElementById('productName').innerText = product.name;
                document.getElementById('productPrice').innerText = product.price;
                document.getElementById('productDescription').innerText = product.description;
                document.getElementById('img1').src=product.image_url;
            } else {
                console.error("Invalid productId");
            }
        });
});

function changeImage(x){
    document.getElementById("img1").src=x.src;
}

function border(x){
    x.style.border="solid black 3px";
}
function removeAllBorder(){
    document.getElementById("s1").style.border="solid black 0px";
    document.getElementById("s2").style.border="solid black 0px";
    document.getElementById("s3").style.border="solid black 0px";
    document.getElementById("s4").style.border="solid black 0px";
    document.getElementById("s5").style.border="solid black 0px";
}

let counterQty=0;
function changeQty(x){
    if(x=="btn+"){
        counterQty++;
    }
    else if(x=="btn-"){
        counterQty--;
    }
    if(counterQty<0) {counterQty=0;}
    document.getElementById("number").innerHTML=String(counterQty);

}


function shoppingInfo(x){
    if(x=="anchorShop"){
        document.getElementById("shoppingInfo").style.display="block";
        document.getElementById("returnPolicy").style.display="none";
        document.getElementById("anchorShop").style.borderBottom="solid rgba(66, 34, 16, 0.7) 5px";
        document.getElementById("anchorPolicy").style.borderBottom="solid rgba(66, 34, 16, 0.7) 0";
    }
    else if(x=="anchorPolicy"){
        document.getElementById("returnPolicy").style.display="block";
        document.getElementById("shoppingInfo").style.display="none";
        document.getElementById("anchorPolicy").style.borderBottom="solid rgba(66, 34, 16, 0.7) 5px";
        document.getElementById("anchorShop").style.borderBottom="solid rgba(66, 34, 16, 0.7) 0";
    }

}



