<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product - Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .product{
            box-shadow: 3px 7px 16px rgb(227, 242, 253); /* Example shadow */
            transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .product:hover{
            box-shadow: 8px 7px 16px rgb(201, 232, 255); /* Example shadow */
            transform: translate(0, -10px); /* Scale up on hover */
        }

        .link-page{
            cursor: pointer;
            background-color: #6b6b6b;
            transition: background-color 0.3s ease-in-out;
        }

        .link-page:hover{
            background-color: #949494;
            transition: background-color 0.3s ease-in-out;
        }

    </style>
  </head>
  <body class="bg-light">

  <!-- Navbar -->

    <nav class="navbar fixed-top shadow" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand" href="#">Fixed top</a>
        </div>
    </nav>

  <!-- ./ Navbar -->
  
  <!-- Content -->
    <main class="container rounded shadow pb-5 px-4 mb-5 bg-white" style="margin-top: 85px;">

        <h1 class="text-center mt-5 mb-5">Our Products</h1>

      <!-- search -->
        <form class="row">
            <div class="col-6 row mb-3">
                <div class="col">
                    <label for="search-brand" class="form-label">Brand :</label>
                    <input id="search-brand" type="text" class="user-input form-control" placeholder="Input Brand Here" aria-label="First name">
                </div>
                <div class="col">
                    <label for="search-model" class="form-label">Model :</label>
                    <input id="search-model" type="text" class="user-input form-control" placeholder="Input Model Here" aria-label="Last name">
                </div>
            </div>
        </form>
      <!-- ./ search -->

      <!-- List of Products -->

      <div id="list-products" class="list row mt-5 mb-3">

          <!-- <div class="card col-4 mx-2 product" style="width: 18rem;">
              <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                  <hr>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="card-link">Card link</a>
                  <a href="#" class="card-link">Another link</a>
              </div>
          </div> -->

          
          
        </div>


      <!-- ./ List of Products -->

      <!-- link pagination -->
    
      <div id="pagination-links" class="pagination"></div>
    
      <!-- ./ link pagination -->
    </main>
  <!-- ./ Content -->



    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>

        const setLoadingGetProduct = () => {
            const listProducts = document.getElementById("list-products")
            listProducts.innerHTML = `<div class="text-center">Loading Memuat Data Product....</div>`

            //hapus link pagination
            const paginationLinks = document.getElementById("pagination-links")
            paginationLinks.innerHTML = ""
        }

        
        getProduct()
        /* Get All Products */ 
        
        function getProduct(){
            
            setLoadingGetProduct()
            axios.get('/api/products')  // Replace with your API endpoint
            .then(response => {
                // Handle success - response will contain the data from the server
                createCards(response.data)
                createLinkPagination(response.data)
                
            })
            .catch(error => {
                // Handle error
                console.error('There was an error making the GET request!', error);
            });
        }
        /* ./ Get All Products */ 

        

        /* Search Products */

        let typingTimer;                // Timer identifier
        const doneTypingInterval = 1000; // Time in ms (1 second)
        const inputSearchBrand = document.getElementById('search-brand')
        const inputSearchModel = document.getElementById('search-model')

        // setelah menekan keyboard pada input search brand, maka jalankan doneTyping untuk mengambil data ke server
        inputSearchBrand.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        // ketika menekan keyboar, hapus time interval
        inputSearchBrand.addEventListener('keydown', () => {
            clearTimeout(typingTimer);
        });

        // setelah menekan keyboard pada input search model, maka jalankan doneTyping untuk mengambil data ke server
        inputSearchModel.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        // ketika menekan keyboar, hapus time interval
        inputSearchModel.addEventListener('keydown', () => {
            clearTimeout(typingTimer);
        });

        // eksekusi setelah 1 detik user tidak menekan keyboard 
        function doneTyping() {
            setLoadingGetProduct()
            axios.get('/api/search-products', {
                params: {
                    brand: (inputSearchBrand.value) ? inputSearchBrand.value : "",
                    model: (inputSearchModel.value) ? inputSearchModel.value : ""
                }
                
            })  
            .then(response => {
                createCards(response.data)
                createLinkPagination(response.data)
            })
            .catch(error => {
                // Handle error
                console.error('There was an error making the GET request!', error);
            });
        }

        /* ./ Search Products */

        /* set card products */ 
        const createCards = (Products) => {

            const listProducts = document.getElementById("list-products")
            listProducts.innerHTML = ""

            if(Products.data){
                try {
                                       
                    Products.data.forEach(product => {
    
                        const cardDiv = document.createElement('div');
    
                        cardDiv.innerHTML = 
                                `<div class="card-body">
                                    <h5 class="card-title">${product.brand}</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">
                                        ${(product.model) ? product.model : '-'}
                                    </h6>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">
                                        ${(product.price) ? product.price : '-'}
                                    </h6>
    
                                    <hr>
                                    
                                    <div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item mx-0 px-0 py-1">
                                                <span class="fw-bold">screen size : </span>
                                                <span>${(product.screen_size) ? product.screen_size : '-'}</span>
                                            </li>
                                            <li class="list-group-item mx-0 px-0 py-1">
                                                <span class="fw-bold">color : </span>
                                                <span>${(product.color) ? product.color : '-'}</span>
                                            </li>
                                            <li class="list-group-item mx-0 px-0 py-1">
                                                <span class="fw-bold">Harddisk : </span>
                                                <span>${(product.harddisk) ? product.harddisk : '-'}</span>
                                            </li>
                                            <li class="list-group-item mx-0 px-0 py-1">
                                                <span class="fw-bold">CPU : </span>
                                                <span>${(product.cpu) ? product.cpu : '-'}</span>
                                            </li>
                                            <li class="list-group-item mx-0 px-0 py-1">
                                                <span class="fw-bold">RAM : </span>
                                                <span>${(product.ram) ? product.ram : '-'}</span>
                                            </li>
                                            <li class="list-group-item mx-0 px-0 py-1">
                                                <span class="fw-bold">OS : </span>
                                                <span>${(product.OS) ? product.OS : '-'}</span>
                                            </li>
                                            <li class="list-group-item mx-0 px-0 py-1">
                                                <span class="fw-bold">Special Features : </span>
                                                <span>${(product.special_features) ? product.special_features : '-'}</span>
                                            </li>
                                            <li class="list-group-item mx-0 px-0 py-1">
                                                <span class="fw-bold">Graphics : </span>
                                                <span>${(product.graphics) ? product.graphics : '-'}</span>
                                            </li>
                                            <li class="list-group-item mx-0 px-0 py-1">
                                                <span class="fw-bold">Graphics Coprocessor : </span>
                                                <span>${(product.graphics_coprocessor) ? product.graphics_coprocessor : '-'}</span>
                                            </li>
                                            <li class="list-group-item mx-0 px-0 py-1">
                                                <span class="fw-bold">CPU Speed : </span>
                                                <span>${(product.cpu_speed) ? product.cpu_speed : '-'}</span>
                                            </li>
                                            <li class="list-group-item mx-0 px-0 py-1">
                                                <span class="fw-bold">Rating : </span>
                                                <span>${(product.rating) ? product.rating : '-'}</span>
                                            </li>
                                            
                                        </ul>
                                    </div>
    
                                </div>
                                `
    
    
                        cardDiv.classList.add('card')
                        cardDiv.classList.add('col-3')
                        cardDiv.classList.add('mx-2')
                        cardDiv.classList.add('mb-4')
                        cardDiv.classList.add('product')
                        cardDiv.style.width = '24rem'
    
                        listProducts.appendChild(cardDiv)
    
                    });
    
                } catch (err) {
                    console.error(err)
                }
            }

        }
        /* ./ set card products */

        /* set link pagination */ 

        const createLinkPagination = (Products) => {

            const paginationLinks = document.getElementById("pagination-links")
            paginationLinks.innerHTML = ""

            if(Products.links){
                try {
                                       
                    Products.links.forEach(paginationLink => {
    
                        const linkSpan = document.createElement('span');
    
                        linkSpan.innerHTML = `${paginationLink.label}`
    
    
                        linkSpan.classList.add('text-white')
                        linkSpan.classList.add('rounded')
                        linkSpan.classList.add('mx-1')
                        linkSpan.classList.add('px-2')
                        linkSpan.classList.add('py-1')
                        linkSpan.classList.add('link-page')
    
                        paginationLinks.appendChild(linkSpan)
    
                    });
    
                } catch (err) {
                    console.error(err)
                }
            }

        }

    //     <div id="pagination-links" class="pagination">
    //     <span class="text-white rounded  mx-1 px-2 py-1 link-page">1</span>
    //     <span class="text-white rounded  mx-1 px-2 py-1 link-page">2</span>
    //     <span class="text-white rounded  mx-1 px-2 py-1 link-page">3</span>
    //   </div>

        /* ./ set link pagination */ 

        
                
            
        
    </script>
  </body>
</html>