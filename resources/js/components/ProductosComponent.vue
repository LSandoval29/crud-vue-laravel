<template>
    <div class="row">
        <div class="col-md-6">
            <form @submit.prevent="editarProducto(producto)" v-if="editar">
                <div class="card border-secondary">
                    <div class="card-header">
                        <h3 class="h3 mb-2 font-weight-bold text-secondary">
                            Editar Productos
                        </h3>
                    </div>

                    <div class="card-body">
                        <input
                            type="text"
                            placeholder="Nombre del producto"
                            class="form-control mb-2"
                            v-model="producto.nombre"
                        />
                        <input
                            type="text"
                            placeholder="Descripción"
                            class="form-control mb-2"
                            v-model="producto.descripcion"
                        />
                        <input
                            type="text"
                            placeholder="Precio"
                            class="form-control mb-2"
                            v-model="producto.precio"
                        />
                        <select
                            class="form-control mb-2"
                            v-model="producto.category_id"
                        >
                            <option value="1">Computadoras</option>
                            <option value="2">Periféricos</option>
                        </select>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-warning" type="submit">
                            Guardar
                        </button>
                        <button
                            class="btn btn-danger"
                            type="submit"
                            @click="cancelarEdicion"
                        >
                            Cancelar
                        </button>
                    </div>
                </div>
            </form>

            <form @submit.prevent="agregar()" v-else>
                <div class="card border-info">
                    <div class="card-header">
                        <h3 class="h3 mb-2 font-weight-bold text-primary">
                            Agregar Productos
                        </h3>
                    </div>
                    <div class="card-body">
                        <input
                            type="text"
                            placeholder="Nombre del producto"
                            class="form-control mb-2"
                            v-model="producto.nombre"
                        />
                        <input
                            type="text"
                            placeholder="Descripción"
                            class="form-control mb-2"
                            v-model="producto.descripcion"
                        />
                        <input
                            type="text"
                            placeholder="Precio"
                            class="form-control mb-2"
                            v-model="producto.precio"
                        />
                        <select
                            class="form-control mb-2"
                            v-model="producto.category_id"
                        >
                            <option value="" disabled selected>
                                Seleccione la categoria...
                            </option>
                            <option value="1">Computadoras</option>
                            <option value="2">Periféricos</option>
                        </select>
                    </div>

                    <div class="card-footer">
                        <button
                            class="btn btn-success float-right"
                            type="submit"
                        >
                            <i class="fas fa-plus-circle"></i> Agregar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <!--<h3 class="h3 mb-2 font-weight-bold text-primary">Productos</h3>-->
            <ul class="list-group">
                <li
                    class="list-group-item"
                    v-for="item in productos.data"
                    :key="item.id"
                >
                    <span class="badge badge-primary float-right">
                        {{ item.updated_at }}
                    </span>
                    <h3 class="h4 font-weight-bold">{{ item.nombre }}</h3>
                    <p>{{ item.descripcion }}</p>
                    <p>{{ item.precio }}</p>
                    <p>
                        <button
                            class="btn btn-warning btn-sm"
                            @click="editarFormulario(item)"
                        >
                            <i class="fas fa-edit"></i>
                            Editar
                        </button>
                        <button
                            class="btn btn-danger btn-sm"
                            @click="eliminarProducto(item, index)"
                        >
                            <i class="fas fa-trash-alt"></i>
                            Eliminar
                        </button>
                    </p>
                </li>
            </ul>
            <div class="float-right mt-3">
                <pagination
                    :data="productos"
                    @pagination-change-page="obtenerProductos"
                ></pagination>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            productos: {},
            producto: {
                nombre: "",
                descripcion: "",
                precio: "",
                category_id: ""
            },
            editar: false
        };
    },
    mounted() {
        this.obtenerProductos();
    },
    methods: {
        obtenerProductos(page = 1) {
            axios.get("/products?page=" + page).then(response => {
                this.productos = response.data;
                console.log(this.productos);
            });
        },
        agregar() {
            if (
                this.producto.nombre.trim() === "" ||
                this.producto.descripcion.trim() === "" ||
                this.producto.precio.trim() === "" ||
                this.producto.category_id.trim() === ""
            ) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Los campos no pueden estar vacios!"
                });
                return;
            }

            const productoNuevo = this.producto; //Guardamos el producto en el producto agregado
            this.producto = {
                nombre: "",
                descripcion: "",
                precio: "",
                category_id: ""
            }; //Ponemos en blanco los inputs

            axios
                .post("/products", productoNuevo) //Peticion post para agregar productos:
                .then(res => {
                    const productoServidor = res.data;
                    //this.productos.create(productoServidor); //AGREGAMOS AL ARREGLO DE LA VISTA EL NUEVO PRODUCTO
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Producto agregado con éxito!",
                        showConfirmButton: false,
                        timer: 2500
                    });
                });
        },
        editarFormulario(item) {
            this.producto.nombre = item.nombre;
            this.producto.descripcion = item.descripcion;
            this.producto.precio = item.precio;
            this.producto.category_id = item.category_id;
            this.producto.id = item.id;
            this.editar = true;
        },
        editarProducto(producto) {
            const params = {
                nombre: producto.nombre,
                descripcion: producto.descripcion,
                precio: producto.precio,
                category_id: producto.category_id
            };
            axios.put(`/products/${producto.id}`, params).then(res => {
                this.editar = false;
                const index = this.productos.findIndex(
                    item => item.id === producto.id
                );
                this.productos[index] = res.data;
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Producto actualizado con éxito!",
                    showConfirmButton: false,
                    timer: 2500
                });

                this.producto = {
                    nombre: "",
                    descripcion: "",
                    precio: "",
                    category_id: ""
                };

                this.obtenerProductos();
            });
        },
        eliminarProducto(producto, index) {
            Swal.fire({
                title: "¿Estas seguro?",
                text: "El producto se eliminará!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar!"
            }).then(result => {
                if (result.value) {
                    axios.delete(`/products/${producto.id}`).then(() => {
                        this.productos.splice(index, 1); //Eliminamos el producto del arreglo.
                    });
                    Swal.fire(
                        "Eliminado!",
                        "El producto ha sido eliminado.",
                        "success"
                    );
                }
            });
        },
        cancelarEdicion() {
            this.editar = false;
            this.producto = {
                nombre: "",
                descripcion: "",
                precio: "",
                category_id: ""
            };
        }
    }
};
</script>
