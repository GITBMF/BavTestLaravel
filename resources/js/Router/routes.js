// import AllProduct from './components/AllProduct.vue';
// import CreateProduct from './components/CreateProduct.vue';
// import EditProduct from './components/EditProduct.vue';
import ExampleComponent from '../components/ExampleComponent.vue';
import Home from '../Pages/Home.vue';
import Products from '../Pages/Products.vue';

export const routes = [{
        name: 'home',
        path: '/',
        component: Home,
        meta: {
            layout: 'SecondHeader'
        }
    },
    {
        name: 'products',
        path: '/products',
        component: Products
    },
    // {
    //     name: 'acheter',
    //     path: '/acheter',
    //     component: Acheter
    // },
    // {
    //     name: 'contact',
    //     path: '/edit/:id',
    //     component: EditProduct
    // }
];