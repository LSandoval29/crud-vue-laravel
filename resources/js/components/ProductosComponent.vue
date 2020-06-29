<template>
    <div class="row">

        <div class="col-md-6">
            <form @submit.prevent="editarProducto(producto)" v-if="editar">
                <h3 class="h3 mb-2 font-weight-bold text-warning">Editar Productos</h3>
                <input type="text" placeholder="Nombre del producto" class="form-control mb-2" v-model="producto.nombre">
                <input type="text" placeholder="Descripción" class="form-control mb-2" v-model="producto.descripcion">
                <input type="text" placeholder="Precio" class="form-control mb-2" v-model="producto.precio">
                <select class="form-control mb-2" v-model="producto.category_id">
                    <option value="1">Computadoras</option>
                    <option value="2">Periféricos</option>
                </select>
                <button class="btn btn-success" type="submit">Guardar</button>
                <button class="btn btn-danger" type="submit" 
                    @click="cancelarEdicion">Cancelar</button>
            </form>
        
            <form @submit.prevent="agregar()" v-else>
                <h3 class="h3 mb-2 font-weight-bold text-primary">Agregar Productos</h3>
                <input type="text" placeholder="Nombre del producto" class="form-control mb-2" v-model="producto.nombre">
                <input type="text" placeholder="Descripción" class="form-control mb-2" v-model="producto.descripcion">
                <input type="text" placeholder="Precio" class="form-control mb-2" v-model="producto.precio">
                <select class="form-control mb-2" v-model="producto.category_id">
                    <option value="1">Computadoras</option>
                    <option value="2">Periféricos</option>
                </select>
                <button class="btn btn-primary" type="submit">Agregar</button>
            </form>
        </div>

      <div class="col-md-6">
        <h3 class="h3 mb-2 font-weight-bold text-primary">Productos</h3>
        <ul class="list-group">

            <li class="list-group-item" v-for="(item, index) in productos" :key="index">
                <span class="badge badge-primary float-right">
                    {{item.updated_at}}
                </span>
                <h3 class="h4 font-weight-bold">{{item.nombre}}</h3>
                <p>{{item.descripcion}}</p>
                <p>{{item.precio}}</p>
                <p>
                    <button class="btn btn-warning btn-sm" 
                        @click="editarFormulario(item)">Editar</button>
                    <button class="btn btn-danger btn-sm" 
                        @click="eliminarProducto(item, index)">Eliminar</button>
                </p>
            </li>  

        </ul>

      </div>
       
    </div>
</template>

<script>
export default {
    data() {
        return {
            productos:[],
            producto:{nombre:'', descripcion:'', precio:'', category_id:''},
            editar:false
        }
    },
    created(){
        this.obtenerProductos();
    },
    methods:{
        obtenerProductos(){
            axios.get('/products')
                .then(res=>{
                this.productos = res.data;
            })
        },
        agregar(){

            if(this.producto.nombre.trim() === ''||this.producto.descripcion.trim() === '' || this.producto.precio.trim() ==='' || this.producto.category_id.trim() === ''){
                alert('Debes completar todos los campos antes de guardar');
                return;
            }

            const productoNuevo = this.producto//Guardamos el producto en el producto agregado
            this.producto = {nombre: '', descripcion: '', precio: '', category_id: ''}//Ponemos en blaco los inputs

            axios.post('/products', productoNuevo)//Peticion post para agregar productos:
            .then((res) => {
                const productoServidor = res.data;
                this.productos.push(productoServidor);
            });
               
        },
        editarFormulario(item){
            this.producto.nombre = item.nombre;
            this.producto.descripcion = item.descripcion;
            this.producto.precio = item.precio;
            this.producto.category_id = item.category_id;
            this.producto.id = item.id;
            this.editar = true;

        },
        editarProducto(producto){
            const params = {nombre: producto.nombre, descripcion: producto.descripcion, precio: producto.precio, category_id: producto.category_id};
            axios.put(`/products/${producto.id}`, params)
                .then(res=>{
                this.editar = false;
                const index = this.productos.findIndex(item => item.id === producto.id);
                this.productos[index] = res.data;

                this.producto = {nombre:'', descripcion:'', precio:'', category_id:''}

                axios.get('/products')
                .then(res=>{
                    this.productos = res.data;
                })
            })
        },
        eliminarProducto(producto, index){
            const confirmacion = confirm(`Eliminar Producto: ${producto.nombre}`);
            if(confirmacion){
                axios.delete(`/products/${producto.id}`)
                .then(()=>{
                    this.productos.splice(index, 1);//Eliminamos el producto del arreglo.
                })
            }
        },
         cancelarEdicion(){
            this.editar = false;
            this.producto = {nombre: '', descripcion: '', precio: '', category_id: ''};
        }

    }
}
</script>