const search = () =>{
    const searchBox = document.getElementById("searchInput").value.toUpperCase();
    const storeItems = document.getElementById("productList")
    const product = document.querySelectorAll(".box")
    const pName = storeItems.getElementsByTagName("h2")

    for(var i = 0; i<pName.length; i++){
        let match = product[i].getElementsByTagName('h2')[0];

        if(match){
            let textValue = match.textContent || match.innerHTML

            if(textValue.toUpperCase().indexOf(searchBox) > -1){
                product[i].style.display="";
            }else{
                product[i].style.display="NONE";
            }
        }
    }

}
function sortProducts() {
    const sortOption = document.getElementById('sortOptions').value;
    const storeItems = document.getElementById('productList');
    const products = Array.from(document.querySelectorAll('.box'));

    if (sortOption === 'price low to high') {
        products.sort((a, b) => parseFloat(a.getAttribute('data-price')) - parseFloat(b.getAttribute('data-price')));
    }else if (sortOption === 'price high to low') {
        products.sort((a, b) => parseFloat(b.getAttribute('data-price')) - parseFloat(a.getAttribute('data-price')));
    }
    products.forEach(product => {
        productList.appendChild(product);
        product.style.width = '17%';
        product.style.height = '2%';
    });
}


