const Products = [];

let counter=0;
let s="";
let nameOfProduct="";


// let orderContent;

document.addEventListener('DOMContentLoaded', () => {
    fetch('cart.php') // Fetch the JSON data from your PHP file
        .then(response => response.json())
        .then(data => {
            // Replace the existing Products array with the new one
            window.Products = data;

            // Event listener for add-to-cart buttons
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    const productName = event.target.getAttribute('data-product-name');
                    addToCart(productName);
                });
            });

            // Display cart items if on the cart page
            if (document.getElementById('cartProducts')) {
                displayCart();
                findTotPrice();
            }
        })
        .catch(error => console.error('Error fetching product data:', error));
});

function addToCart(productName) {
    const product = findProductByName(productName);
    if (product) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        // Check if product is already in the cart
        const existingProductIndex = cart.findIndex(item => item.name === productName);
        if (existingProductIndex >= 0) {
            cart[existingProductIndex].quantity += 1; // Increment quantity if product exists
        } else {
            product.quantity = 1; // Set initial quantity
            cart.push(product);
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`${productName} has been added to the cart!`);
    } else {
        console.error(`Product with name ${productName} not found.`);
    }
}

function findProductByName(name) {
    const allProducts = [].concat(...Object.values(window.Products));
    return allProducts.find(product => product.name === name);
}

function displayCart() {
    const cartProductsDiv = document.getElementById('cartProducts');
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    cartProductsDiv.innerHTML = ''; // Clear the cart div

    cart.forEach((product, index) => {
        const productDiv = document.createElement('div');
        const productId = `product${index}`;

        productDiv.id = productId;
        productDiv.innerHTML = `
            <img src=${product.image_url} alt="${product.name}">
            <div style="display: inline;">
                <span style="margin-right:1%;">${product.price}</span>
                <span id="btn+" onclick="changeQtyCart(this, ${index})" class="qty" style="border: solid #595353 7px;">+</span>
                <span id="number">${product.quantity}</span>
                <span id="btn-" onclick="changeQtyCart(this, ${index})" class="qty" style="border: solid #595353 7px; margin-right:1%;">-</span>
                   <span class="totPrice">${calculateTotalPrice(product.price, product.quantity)}</span>
                <span id="close2" onclick="closeCart(${index})"><i class="fa fa-close" style="font-size:25px; padding-left: 6%;"></i></span>
<!--                <input type="submit" value="Delete" id="close2" onclick="closeCart(${index})" style="margin: 2% 2% 2% 9%; font-size: 18px;  font-weight: bold; color: #f1f1f1; background-color: #3e220b; border-radius: 5px;">-->

            </div>
        `;

        // var arr= new Array(3);
        // arr[0]=product.name;
        // arr[1]=product.price;
        // arr[2]=product.quantity;
        // var src1="cartWDb.php?cartItems="+arr;
        // window.location.href=src1;
        //

        let usr={
            "pname":product.name,
            "pprice":product.price,
            "pqty":product.quantity
        }

        fetch("cartWDb.php",{
            "method":"POST",
            "headers":{
                "Content-Type": "application/json; charset=utf-8"
            },
            "body": JSON.stringify(usr)
        })



        // orderContent= {
        //     "operation":"add",
        //     "pname":product.name,
        //     "pprice":product.price,
        //     "pqty":product.quantity,
        //     "tot_price":product.price
        // }
        // fetch("orderItems.php",{
        //     "method":"POST",
        //     "headers":{
        //         "Content-Type": "application/json; charset=utf-8"
        //     },
        //     "body": JSON.stringify(orderContent)
        // })

        cartProductsDiv.appendChild(productDiv);
    });
}

function changeQtyCart(btn, index) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const product = cart[index];
    const numberSpan = btn.id === 'btn+' ? btn.nextElementSibling : btn.previousElementSibling;
    let quantity = parseInt(numberSpan.textContent);

    if (btn.id === 'btn+') {
        quantity += 1;
        s="btn+";
    } else if (btn.id === 'btn-') {
        quantity = Math.max(1, quantity - 1);
        s="btn-";
    }

    numberSpan.textContent = quantity;
    product.quantity = quantity;
    localStorage.setItem('cart', JSON.stringify(cart));


    let qty={
        "product_name":product.name,
        "pQty": product.quantity
    }

    fetch("changeQty.php",{
        "method":"POST",
        "headers":{
            "Content-Type": "application/json; charset=utf-8"
        },
        "body": JSON.stringify(qty)
    })
    nameOfProduct=product.name;

    updateTotalPrice(btn, product.price, quantity);
}

function updateTotalPrice(btn, price, quantity) {
    // Find the closest product div
    const productDiv = btn.closest('div');
    // Find the specific total price span within this product div
    const totalPriceSpan = productDiv.querySelector('.totPrice');
    totalPriceSpan.textContent = calculateTotalPrice(price, quantity);
    findTotPrice();
}

function calculateTotalPrice(price, quantity) {
    const numericPrice = parseFloat(price.replace('$', '').replace(',', ''));

    if (s === "btn+") {
        counter+= numericPrice * quantity;
    } else if (s === "btn-") {
        counter-= numericPrice * quantity;
    }
    else{  counter+= numericPrice * quantity;}


    let priceTot={
        "product_name":nameOfProduct,
        "tot_price":numericPrice * quantity
    }

    fetch("totPriceCart.php",{
        "method":"POST",
        "headers":{
            "Content-Type": "application/json; charset=utf-8"
        },
        "body": JSON.stringify(priceTot)
    })



    return `$${(numericPrice * quantity).toLocaleString()}`;
}

function closeCart(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const product = cart[index];
    counter-=cart[index].quantity*cart[index].price;
    cart.splice(index, 1); // Remove the item from the array
    localStorage.setItem('cart', JSON.stringify(cart)); // Update the cart in local storage
    displayCart(); // Refresh the cart display


    let deleteProduct={
        "product_name":product.name
    }


    fetch("deleteItem.php",{
        "method":"POST",
        "headers":{
            "Content-Type": "application/json; charset=utf-8"
        },
        "body": JSON.stringify(deleteProduct)
    })
}

function findTotPrice(){
    document.getElementById("totPrice2").innerText=counter+" $";
}

function fillOrder(){

    let fillOrder={
        "tot_price":counter
    }


    fetch("buyNow.php",{
        "method":"POST",
        "headers":{
            "Content-Type": "application/json; charset=utf-8"
        },
        "body": JSON.stringify(fillOrder)
    })
}