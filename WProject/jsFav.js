// const Products3 = [];
//
// // let orderContent;
//
// document.addEventListener('DOMContentLoaded', () => {
//     fetch('favouritePhp.php') // Fetch the JSON data from your PHP file
//         .then(response => response.json())
//         .then(data => {
//             // Replace the existing Products array with the new one
//             window.Products3 = data;
//
//             // Event listener for add-to-cart buttons
//             document.querySelectorAll('.add-to-fav').forEach(button => {
//                 button.addEventListener('click', (event) => {
//                     event.preventDefault();
//                     const productName = event.target.getAttribute('data-product-name2');
//                     addToCart(productName);
//                 });
//             });
//
//             // Display cart items if on the cart page
//             if (document.getElementById('favProducts')) {
//                 displayCart();
//             }
//         })
//         .catch(error => console.error('Error fetching product data:', error));
// });
//
// function addToCart(productName) {
//     const product = findProductByName(productName);
//     if (product) {
//         let cart = JSON.parse(localStorage.getItem('fav')) || [];
//         // Check if product is already in the cart
//         const existingProductIndex = cart.findIndex(item => item.name === productName);
//         if (existingProductIndex >= 0) {
//             cart[existingProductIndex].quantity += 1; // Increment quantity if product exists
//         } else {
//             product.quantity = 1; // Set initial quantity
//             cart.push(product);
//         }
//         localStorage.setItem('fav', JSON.stringify(cart));
//         alert(`${productName} has been added to the Fav!`);
//     } else {
//         console.error(`Product with name ${productName} not found.`);
//     }
// }
//
// function findProductByName(name) {
//     const allProducts = [].concat(...Object.values(window.Products3));
//     return allProducts.find(product => product.name === name);
// }
//
// function displayCart() {
//     const cartProductsDiv = document.getElementById('favProducts');
//     const cart = JSON.parse(localStorage.getItem('fav')) || [];
//     cartProductsDiv.innerHTML = ''; // Clear the cart div
//
//     cart.forEach((product, index) => {
//         const productDiv = document.createElement('div');
//         const productId = `product${index}`;
//
//         productDiv.id = productId;
//         productDiv.innerHTML = `
//             <img src=${product.image_url} alt="${product.name}">
//             <div style="display: inline;">
//                 <span style="margin-right:1%;">${product.price}</span>
//                 <span id="close2" onclick="closeCart(${index})"><i class="fa fa-close" style="font-size:25px; padding-left: 6%;"></i></span>
//             </div>
//         `;
//
//         let usr={
//             "pname":product.name,
//             "pprice":product.price,
//             "pqty":product.quantity
//         }
//
//         fetch("favWDB.php",{
//             "method":"POST",
//             "headers":{
//                 "Content-Type": "application/json; charset=utf-8"
//             },
//             "body": JSON.stringify(usr)
//         })
//
//         cartProductsDiv.appendChild(productDiv);
//     });
// }
//
//
// function closeCart(index) {
//     let cart = JSON.parse(localStorage.getItem('fav')) || [];
//     const product = cart[index];
//     counter-=cart[index].quantity*cart[index].price;
//     cart.splice(index, 1); // Remove the item from the array
//     localStorage.setItem('fav', JSON.stringify(cart)); // Update the cart in local storage
//     displayCart(); // Refresh the cart display
//
//
//     let deleteProduct={
//         "product_name":product.name
//     }
//
//
//     fetch("deleteItem.php",{
//         "method":"POST",
//         "headers":{
//             "Content-Type": "application/json; charset=utf-8"
//         },
//         "body": JSON.stringify(deleteProduct)
//     })
// }
//
//
const productDataList = [];

document.addEventListener('DOMContentLoaded', () => {
    fetch('favouritePhp.php') // Fetch the JSON data from your PHP file
        .then(response => response.json())
        .then(data => {
            // Replace the existing Products array with the new one
            window.productDataList = data;

            // Event listener for add-to-favorites buttons
            document.querySelectorAll('.add-to-fav').forEach(button => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    const productName = event.target.getAttribute('data-product-name2');
                    addToFavorites(productName);
                });
            });

            // Display favorite items if on the favorites page
            if (document.getElementById('favProducts')) {
                displayFavorites();
            }
        })
        .catch(error => console.error('Error fetching product data:', error));
});

function addToFavorites(productName) {
    const product = findProductByName(productName);
    if (product) {
        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        // Check if product is already in the favorites
        const existingProductIndex = favorites.findIndex(item => item.name === productName);
        if (existingProductIndex >= 0) {
            favorites[existingProductIndex].quantity += 1; // Increment quantity if product exists
        } else {
            product.quantity = 1; // Set initial quantity
            favorites.push(product);
        }
        localStorage.setItem('favorites', JSON.stringify(favorites));
        alert(`${productName} has been added to the favorites!`);
    } else {
        console.error(`Product with name ${productName} not found.`);
    }
}

function findProductByName(name) {
    const allProducts = [].concat(...Object.values(window.productDataList));
    return allProducts.find(product => product.name === name);
}

function displayFavorites() {
    const favoritesDiv = document.getElementById('favProducts');
    const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
    favoritesDiv.innerHTML = ''; // Clear the favorites div

    favorites.forEach((product, index) => {
        const productDiv = document.createElement('div');
        const productId = `product${index}`;

        productDiv.id = productId;
        productDiv.innerHTML = `
            <img src=${product.image_url} alt="${product.name}">
            <div style="display: inline;">
               <span style="margin-right:7%;">${product.name}</span>
                <span style="margin-right:7%;">${product.price} $</span>
                <span id="close2" onclick="removeFavorite(${index})"><i class="fa fa-close" style="font-size:25px; padding-left: 6%;"></i></span>
            </div>
        `;

        let productData = {
            "productName": product.name,
            "productPrice": product.price
        }

        fetch("favWDB.php", {
            "method": "POST",
            "headers": {
                "Content-Type": "application/json; charset=utf-8"
            },
            "body": JSON.stringify(productData)
        })

        favoritesDiv.appendChild(productDiv);
    });
}

function removeFavorite(index) {
    let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
    const product = favorites[index];
    favorites.splice(index, 1); // Remove the item from the array
    localStorage.setItem('favorites', JSON.stringify(favorites)); // Update the favorites in local storage
    displayFavorites(); // Refresh the favorites display

    let deleteProductData = {
        "productName": product.name
    }

    fetch("deleteItemFav.php", {
        "method": "POST",
        "headers": {
            "Content-Type": "application/json; charset=utf-8"
        },
        "body": JSON.stringify(deleteProductData)
    })
}
