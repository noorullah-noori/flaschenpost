<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FlashenPost</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <div class="container">


        <div class="row">
            <div class="container">
                <div class="row mt-5 mb-5">
                    <div class="col-md-4">
                        <button onclick="showSorted()" class="btn btn-secondary">Sort</button>
                    </div>
                    <div class="col-md-4">
                        <button onclick="toggleView()" class="btn btn-secondary">View</button>
                    </div>
                    <div class="col-md-4">
                        <button onclick="showFiltered()" class="btn btn-secondary">Filter</button>
                    </div>
                </div>

                <div class="container" id="detailed">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>

<script>
    function createCard(product) {
        var card = document.createElement('div');
        card.setAttribute('class', 'col-md-4 mt-2 mb-2');
        card.innerHTML = `
                        <div class="card" style="width: 18rem;">
                            <img class="img-fluid float-left" style="height:200px;width:80px" src="${product.articles[0].image}" alt="Card image cap">
                            <div class="card-body float_right" style="display: block">
                            <h5 class="card-title">${product.brandName}</h5>
                            <p class="card-text">${product.articles[0].price}</p>
                            <p class="card-text">${product.name}</p>
                            </div>
                        </div>
        `;
        return card;
    }

    function populateView(products) {
        var container = document.querySelector('#detailed .row');
        container.innerHTML = '';
        cards = products.map(product => createCard(product));
        cards.forEach(card => container.appendChild(card));
    }

    function showAll() {
        fetch("http://localhost:8000/products")
            .then(res => res.json())
            .then(products => {
                populateView(products);
            });
    }

    function showSorted() {
        fetch("http://localhost:8000/products/sort")
            .then(res => res.json())
            .then(products => {
                populateView(products);
            });
    }

    function showFiltered() {
        fetch("http://localhost:8000/products/filter")
            .then(res => res.json())
            .then(products => {
                populateView(products);
            });
    }

    function toggleView() {
        var cardsDetails = document.querySelectorAll('.card-body');
        cardsDetails.forEach(cd => {
            cd.style.display == 'block' ? cd.style.display = 'none' : cd.style.display = 'block';
        });
    }

    showAll();
</script>

</html>