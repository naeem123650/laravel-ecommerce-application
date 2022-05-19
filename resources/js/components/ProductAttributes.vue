<template>
    <div>
        <div class="tile">
            <h3 class="tile-title">Attributes</h3>
            <hr>
            <div class="tile-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="parent">Select an Attribute <span class="m-l-5 text-danger"> *</span></label>
                            <select id=parent class="form-control custom-select mt-15" v-model="attribute" @change="selectAttribute(attribute)">
                                <option :value="attribute" v-for="attribute in attributes" :key="attribute.id">{{ attribute.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tile" v-if="attributeSelected">
            <h3 class="tile-title">{{ attributeValueTitle }}</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="values">Select an value <span class="m-l-5 text-danger"> *</span></label>
                        <select id=values class="form-control custom-select mt-15" v-model="attrValue" @change="selectValue(attrValue)">
                            <option value="" selected disabled>Attribute Value</option>
                            <option :value="attrValue" v-for="attrValue in attributeValues" :key="attrValue.id">{{ attrValue.value }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" v-if="valueSelected">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="quantity">Quantity</label>
                        <input class="form-control" type="number" id="quantity" v-model="currentQty"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="price">Price</label>
                        <input class="form-control" type="text" id="price" v-model="currentPrice"/>
                        <small class="text-danger">This price will be added to the main price of product on frontend.</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-sm btn-primary" @click="addProductAttr()">
                         {{ productAttributeButtonText }}
                    </button>
                </div>
            </div>
        </div>
        <div class="tile">
            <h3 class="tile-title">Product Attributes</h3>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                        <tr class="text-center">
                            <th>Value</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="attribute in productAttributes" :key="attribute.id">
                            <td style="width: 25%" class="text-center">{{ attribute.value }}</td>
                            <td style="width: 25%" class="text-center">{{ attribute.quantity }}</td>
                            <td style="width: 25%" class="text-center">{{ attribute.price }}</td>
                            <td style="width: 25%" class="text-center">
                                <button class="btn btn-sm btn-warning" @click="editProductAttribute(attribute)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                        <modal :show="showModal" @close="showModal = false" :productAttr=attribute>
                                            <template #header>
                                                <h3>custom header</h3>
                                            </template>
                                        </modal>
                                <button class="btn btn-sm btn-danger" @click="deleteProductAttribute(attribute)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Modal from './Modal.vue'

    export default {
        name:'product-attributes',
        props:['productid'],
        components:{
            Modal
        },
        data(){
            return {
                showModal: false,
                productAttributes : [],
                attributes: [],
                attribute: {},
                attributeSelected : false,
                attributeValues: [],
                attrValue:"",
                valueSelected : false,
                currentAttributeId: '',
                currentValue: '',
                currentQty: '',
                currentPrice: '',
                attributeValueTitle:'Add Attributes To Product',
                productAttributeButtonText: "Add Product Attribute"
            }
        },
        created:function(){
            this.loadProductAttributes(this.productid);
            this.loadAtrributes();
        },
        methods:{
            editProductAttribute(attr){
                this.showModal = true;
                // this.valueSelected = true;
                // this.attributeValueTitle = 'Edit Attributes To Product';
                // this.productAttributeButtonText = "Update Product Attribute";
                // this.attrValue = attr.value;
                // console.log(attr);

            },
            deleteProductAttribute(attr){
                axios.post('/admin/products/attributes/delete',{
                    product_attr_id:attr.id
                }).then((response) => {
                    this.$swal("Success! "+ response.data.message,{
                        icon:response.data.type
                    })
                    this.loadProductAttributes(this.productid);
                }).catch((err) => {
                    console.log(err);
                });
            },
            addProductAttr(){
                if(this.currentQty == "" || this.currentQty == undefined || this.currentPrice == "" || this.attrValue == ""){
                    this.$swal("Please fillout required fields.",{
                        icon:"error"
                    });
                }else{
                    // let _this = this;
                    let data = {
                        attribute_id: this.currentAttributeId,
                        value: this.currentValue,
                        quantity : this.currentQty,
                        price: this.currentPrice,
                        product_id: this.productid,
                    };

                    axios.post('/admin/products/attributes/add',{
                        data:data
                    }).then((response)=>{
                        this.$swal("Success! "+ response.data.message,{
                            icon: response.data.type
                        });
                        this.currentValue = "";
                        this.currentQty = "";
                        this.currentPrice = "";
                        this.valueSelected = false;
                        this.attrValue = ""
                    }).catch((err)=>{
                        console.log(err);
                    });
                    this.loadProductAttributes(this.productid);
                }

            },
            selectValue(value){
                // console.log(value);
                this.valueSelected=true;
                this.currentValue = value.value;
                this.currentPrice = value.price;
                this.currentQty = value.quantity;
            },
            selectAttribute(attribute){
                var _this = this;
                _this.currentAttributeId = attribute.id;

                axios.post('/admin/products/attributes/values',{
                    id: attribute.id
                }).then((response)=>{
                    this.attributeValues = response.data;
                }).catch((err) => {
                    console.log(err);
                });
                this.attributeSelected = true;
            },
            loadProductAttributes(id){
                axios.post('/admin/products/attributes',{
                    id:id
                }).then((response) => {
                    this.productAttributes = response.data;
                }).catch((err) => {
                    console.log(err);
                });
            },
            loadAtrributes(){
                axios.get('/admin/products/attributes/load')
                .then((response) => {
                    this.attributes = response.data;
                }).catch((err) => {
                    console.log(err);
                })
            }
        }
    }
</script>
