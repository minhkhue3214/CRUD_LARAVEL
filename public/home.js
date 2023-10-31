const caculatePrice = () => {
    let productList = JSON.parse(localStorage.getItem('productList')) || [];
    let packageList = JSON.parse(localStorage.getItem('packageList')) || [];
    const totalPriceProduct = calculateTotalPrice(productList);
    const totalPricePackage = calculateTotalPrice(packageList);

    let totalPrice = totalPriceProduct + totalPricePackage
    document.getElementById("totalPrice").textContent = "Tổng tiền cần thanh toán: " + totalPrice;
    localStorage.setItem("totalPrice", totalPrice.toString());
}

function calculateTotalPrice(arr) {
    let total = 0;
    for (const item of arr) {
        total += item.price * item.quantity;
    }
    return total;
}

const resetCart = () => {
    let packageList = JSON.parse(localStorage.getItem('packageList')) || [];
    let productList = JSON.parse(localStorage.getItem('productList')) || [];

    if (productList.length > 0) {
        const tbody = document.querySelector('.tbody-product');
        tbody.innerHTML = '';
        productList.forEach(function (product, index) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <th scope="row">${index + 1}</th>
                <td>${product.title}</td>
                <td>${product.price}</td>
                <td>
                    <input name="quantity_product[]" type="number" class="form-control"
                        value="${product.quantity}" placeholder="quantity"
                        aria-describedby="basic-addon1" style="width: 120px; height: 30px;">
                </td>
                <td>
                    <button type="button" class="btn btn-danger delete-product" onClick="deleteProduct(${product.id})">Delete</button>
                </td>
                `;
            tbody.appendChild(tr);
        });

    } else {
        const tbody = document.querySelector('.tbody-product');
        tbody.innerHTML = '';
    }

    if (packageList.length > 0) {
        const tbody = document.querySelector('.tbody-package');
        tbody.innerHTML = '';
        packageList.forEach(function (package, index) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <th scope="row">${index + 1}</th>
                <td>${package.name}</td>
                <td>${package.price}</td>
                <td>
                    <input name="quantity_product[]" type="number" class="form-control"
                        value="${package.quantity}" placeholder="quantity"
                        aria-describedby="basic-addon1" style="width: 120px; height: 30px;">
                </td>
                <td>
                    <button type="button" class="btn btn-danger delete-product" onClick="deletePackage(${package.id})">Delete</button>
                </td>
                `;
            tbody.appendChild(tr);
        });

    } else {
        const tbody = document.querySelector('.tbody-package');
        tbody.innerHTML = '';
    }
    caculatePrice()
}


document.addEventListener('click', function (e) {
    if (e.target.classList.contains('save-product')) {
        let productList = JSON.parse(localStorage.getItem('productList')) || [];
        e.preventDefault();

        const productData = e.target.getAttribute('data-product');
        const product = JSON.parse(productData);
        let targetID = product.id;

        var isIDExists = productList.some(function (product) {
            return product.id === targetID;
        });

        localStorage.setItem('productList', JSON.stringify(productList));

        if (isIDExists) {
            alert("sản phẩm đã tồn tại trong giỏ hàng")
        } else {
            const tbody = document.querySelector('.tbody-product');
            tbody.innerHTML = '';

            product.quantity = 1;
            productList.push(product);
            localStorage.setItem('productList', JSON.stringify(productList));

            productList.forEach(function (product, index) {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <th scope="row">${index + 1}</th>
                <td>${product.title}</td>
                <td>${product.price}</td>
                <td>
                <input name="quantity_product[]" type="number" class="form-control"
                    value="${product.quantity}" placeholder="quantity"
                    aria-describedby="basic-addon1" style="width: 120px; height: 30px;"
                    onClick="updateProductQuantity(this,${product.id})">
                </td>

                <td>
                    <button type="button" class="btn btn-danger delete-product" onClick="deleteProduct(${product.id})">Delete</button>
                </td>
                `;
                tbody.appendChild(tr);
            });

        }
        caculatePrice()
    }
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('save-package')) {
        let packageList = JSON.parse(localStorage.getItem('packageList')) || [];
        e.preventDefault();

        const packageData = e.target.getAttribute('data-package');
        const package = JSON.parse(packageData);
        let targetID = package.id;

        var isIDExists = packageList.some(function (package) {
            return package.id === targetID;
        });

        if (isIDExists) {
            alert("gói sản phẩm đã tồn tại trong giỏ hàng")
        } else {
            const tbody = document.querySelector('.tbody-package');
            tbody.innerHTML = '';

            package.quantity = 1;
            packageList.push(package);
            localStorage.setItem('packageList', JSON.stringify(packageList));

            packageList.forEach(function (package, index) {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <th scope="row">${index + 1}</th>
                <td>${package.name}</td>
                <td>${package.price}</td>
                <td>
                <input name="quantity_product[]" type="number" class="form-control"
                    value="${package.quantity}" placeholder="quantity"
                    aria-describedby="basic-addon1" style="width: 120px; height: 30px;"
                    oninput="updatePackageQuantity(this,${package.id})">
                </td>
                <td>
                    <button type="button" class="btn btn-danger delete-product" onClick="deletePackage(${package.id})">Delete</button>
                </td>
                `;
                tbody.appendChild(tr);
            });
        }
        caculatePrice()
    }
});

(function () {
    let productList = JSON.parse(localStorage.getItem('productList')) || [];
    let packageList = JSON.parse(localStorage.getItem('packageList')) || [];

    if (productList.length > 0) {
        let productList = JSON.parse(localStorage.getItem('productList')) || [];
        const tbody = document.querySelector('.tbody-product');
        tbody.innerHTML = '';
        productList.forEach(function (product, index) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <th scope="row">${index + 1}</th>
                <td>${product.title}</td>
                <td>${product.price}</td>
                <td>
                <input name="quantity_product[]" type="number" class="form-control"
                    value="${product.quantity}" placeholder="quantity"
                    aria-describedby="basic-addon1" style="width: 120px; height: 30px;"
                    oninput="updateProductQuantity(this,${product.id})">
                </td>
                <td>
                    <button type="button" class="btn btn-danger delete-product" onClick="deleteProduct(${product.id})">Delete</button>
                </td>
                `;
            tbody.appendChild(tr);
        });

    }

    if (packageList.length > 0) {
        let packageList = JSON.parse(localStorage.getItem('packageList')) || [];
        console.log("packageList", packageList.length);
        const tbody = document.querySelector('.tbody-package');
        tbody.innerHTML = '';

        packageList.forEach(function (package, index) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <th scope="row">${index + 1}</th>
                <td>${package.name}</td>
                <td>${package.price}</td>
                <td>
                <input name="quantity_product[]" type="number" class="form-control"
                    value="${package.quantity}" placeholder="quantity"
                    aria-describedby="basic-addon1" style="width: 120px; height: 30px;"
                    oninput="updatePackageQuantity(this,${package.id})">
                </td>
                <td>
                    <button type="button" class="btn btn-danger delete-product" onClick="deletePackage(${package.id})">Delete</button>
                </td>
                `;
            tbody.appendChild(tr);
        });
    }

    caculatePrice()
})();

document.getElementById("logout-link").addEventListener("click", function (event) {
    localStorage.clear();
});

function deleteProduct(productId) {
    let productList = JSON.parse(localStorage.getItem('productList')) || [];
    const indexToDelete = productList.findIndex(item => item.id === productId);

    productList.splice(indexToDelete, 1);
    localStorage.setItem('productList', JSON.stringify(productList));
    resetCart()
}

function deletePackage(packageId) {
    let packageList = JSON.parse(localStorage.getItem('packageList')) || [];
    const indexToDelete = packageList.findIndex(item => item.id === packageId);

    packageList.splice(indexToDelete, 1);
    localStorage.setItem('packageList', JSON.stringify(packageList));
    resetCart()
    caculatePrice()
}

function updateProductQuantity(productQuantity, productId) {
    let productList = JSON.parse(localStorage.getItem('productList')) || [];

    var newValue = productQuantity.value;

    const updatedProducts = productList.map(product => {
        if (product.id === productId) {
            return {
                ...product,
                quantity: newValue
            };
        }
        return product;
    });

    localStorage.setItem('productList', JSON.stringify(updatedProducts));
    caculatePrice()
}

function updatePackageQuantity(packageQuantity, packageId) {
    let packageList = JSON.parse(localStorage.getItem('packageList')) || [];

    var newValue = packageQuantity.value;

    const updatedPackages = packageList.map(package => {
        if (package.id === packageId) {
            return {
                ...package,
                quantity: newValue
            };
        }
        return package;
    });

    localStorage.setItem('packageList', JSON.stringify(updatedPackages));
    caculatePrice()
}

const clearCart = () => {
    localStorage.clear();
    const tproduct = document.querySelector('.tbody-product');
    const tpackage = document.querySelector('.tbody-package');
    tproduct.innerHTML = '';
    tpackage.innerHTML = '';
    caculatePrice()
}

const Payment = () => {
    let productList = JSON.parse(localStorage.getItem('productList')) || [];
    let packageList = JSON.parse(localStorage.getItem('packageList')) || [];
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    let storedTotalPrice = localStorage.getItem("totalPrice");

    if (productList.length == 0 && packageList.length == 0) {
        alert("Không có sản phẩm nào để thanh toán");
        return;
    }

    $.ajax({
        url: 'home/payment/',
        method: 'POST',
        data: {
            _token: csrfToken, // Thêm CSRF token nếu cần
            productList: productList,
            packageList: packageList,
            storedTotalPrice: storedTotalPrice
        },
        success: function (response) {
            // Xử lý phản hồi từ server sau khi hoàn thành thanh toán
            clearCart();
            alert("Thanh toán sản phẩm thành công")
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.log('Lỗi khi gửi dữ liệu: ' + error);
        }
    });

}
