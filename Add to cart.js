  
  //Define the functions
  let openShopping = document.querySelector('.shopping');
    let closeShopping = document.querySelector('.closeShopping');
    let list = document.querySelector('.list');
    let listCard = document.querySelector('.listCard');
    let body = document.querySelector('body');
    let total = document.querySelector('.total');
    let quantity = document.querySelector('.quantity');

    openShopping.addEventListener('click', () => {
        body.classList.add('active');
    });

    closeShopping.addEventListener('click', () => {
        body.classList.remove('active');
    });

    //Define the food items by their id, name, image source and price
    let products = [
        {
            id: 1,
            name: 'Chicken Burger',
            image: 'Burguer1.png',
            price: 2290
        },
        {
            id: 2,
            name: 'Beef Burger',
            image: 'Burguer4.png',
            price: 3290
        },
        {
            id: 3,
            name: 'Mutton Burger',
            image: 'Burguer2.png',
            price: 4450
        },
        {
            id: 4,
            name: 'Fish Burger',
            image: 'Burguer3.png',
            price: 2450
        },
        {
            id: 5,
            name: 'Hot & Spicy Chicken Pizza',
            image: 'Pizza1.jpg',
            price: 1830
        },
        {
            id: 6,
            name: 'Cheese & Chicken',
            image: 'Pizza 2.png',
            price: 2690,
        },
        {
            id: 7 ,
            name: 'Pepperoni Pizza',
            image: 'Pizza 3.png',
            price: 2590,
        },
        {
            id: 8,
            name: 'Margherita Pizza',
            image: 'Pizza 4.png',
            price: 2590,
        },
        {
            id: 9,
            name: 'Cheese Pasta',
            image: 'Pasta 1.png',
            price: 1290
        },
        {
            id: 10,
            name: 'Chicken Pasta',
            image: 'Pasta 2.png',
            price: 1690
        },
        {
            id: 11,
            name: 'Mushroom Pasta',
            image: 'pasta 3.jpg',
            price: 1490
        },
        {
            id: 12,
            name: 'Mix Pasts',
            image: 'pasta 4.jpg',
            price: 2500
        },
        {
            id: 13,
            name: 'Pomegranate Juice',
            image: 'smoothi1.png',
            price: 1290
        },
        {
            id: 14,
            name: 'Orange Juice',
            image: 'smoothi2.png',
            price: 250
        },
        {
            id: 15,
            name: 'Latte',
            image: 'Matcha Lattes 1.png',
            price: 350
        },
        {
            id: 16,
            name: 'Cofee',
            image: 'Matcha Lattes 2.png',
            price: 250
        },

        {
            id: 17,
            name: 'French Fries',
            image:'Fries.png',
            price: 400
        },

        {
            id: 18,
            name: 'Tacos',
            image: 'Tacos1.png',
            price: 650
        },

        {
            id: 19,
            name: 'Sushi',
            image: 'Sushi1.jpg',
            price: 550
        },
        {
            id: 20,
            name: 'Acai Bowl',
            image: 'Acai Bowl3.jpg',
            price: 650
        },

        {
            id: 21,
            name: 'Egg Avacado Toast',
            image: 'AvacadoToast2.jpg',
            price: 450
        },

        {
            id: 22,
            name: 'Avacado Toast',
            image:'AvacadoToast1.jpg',
            price: 300
        },
        {
            id: 23,
            name: 'Acai Bowl',
            image: 'Acai Bowl2.jpg',
            price: 600
        },
        

    ];

    let listCards = [];
    function addToCard(key) {
        const productId = products[key].id;  // Use the product's id as the key
        if (listCards[productId] == null) {
            // copy product from list to list card
            listCards[productId] = { ...products[key], quantity: 1 };
        } else {
            listCards[productId].quantity++;
        }
        reloadCard();
        }



    initApp();

    function addToCard(key) {
        if (listCards[key] == null) {
            // copy product form list to list card
            listCards[key] = { ...products[key], quantity: 1 };
        } else {
            listCards[key].quantity++;
        }
        reloadCard();
    }

    function reloadCard() {
        listCard.innerHTML = '';
        let count = 0;
        let totalPrice = 0;

        listCards.forEach((value, key) => {
            totalPrice = totalPrice + value.price;
            count = count + value.quantity;

            let newDiv = document.createElement('li');
            newDiv.innerHTML = `
                <div><img src="image/${value.image}"/></div>
                <div>${value.name}</div>
                <div>${value.price.toLocaleString()}</div>
                <div>
                    <button onclick="changeQuantity(${key}, ${value.quantity - 1})">-</button>
                    <div class="count">${value.quantity}</div>
                    <button onclick="changeQuantity(${key}, ${value.quantity + 1})">+</button>
                </div>`;
            listCard.appendChild(newDiv);
        });

        total.innerText = totalPrice.toLocaleString();
        quantity.innerText = count;

        // Set the height of the card based on its scrollHeight
        const card = document.querySelector('.card');
        card.style.height = card.scrollHeight + 'px';
    }


    function changeQuantity(key, quantity) {
        if (quantity === 0) {
            delete listCards[key];
        } else {
            listCards[key].quantity = quantity;
        }
        reloadCard();
    }

