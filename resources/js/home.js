document.addEventListener('click', function(e) {
    if (e.target.classList.contains('save-product')) {
        e.preventDefault();
        let productList = JSON.parse(localStorage.getItem('productList')) || [];
        console.log("productList", productList);


        const productData = e.target.getAttribute('data-product');
        const product = JSON.parse(productData);
        let targetID = product.id;

        var isIDExists = productList.some(function(product) {
            return product.id === targetID;
        });

        if (isIDExists) {
            alert("sản phẩm đã tồn tại trong giỏ hàng")
        } else {
            product.quantity = 1;
            console.log("testing product", JSON.stringify(product));
            productList.push(product);
            localStorage.setItem('productList', JSON.stringify(productList));
        }

    }
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('save-package')) {
        e.preventDefault();
        let packageList = JSON.parse(localStorage.getItem('packageList')) || [];
        console.log("packageList", packageList);


        const packageData = e.target.getAttribute('data-package');
        const package = JSON.parse(packageData);
        let targetID = package.id;

        var isIDExists = packageList.some(function(package) {
            return package.id === targetID;
        });

        if (isIDExists) {
            alert("gói sản phẩm đã tồn tại trong giỏ hàng")
        } else {
            package.quantity = 1;
            console.log("testing package", JSON.stringify(package));
            packageList.push(package);
            localStorage.setItem('packageList', JSON.stringify(packageList));
        }

    }
});

