<template>
    <EShopButton btn-text="VIEW" :onclick="handleOpen" icon-class="fa-solid fa-pen-to-square text-white" />
    <a-modal v-model:open="open" title="Update Product Form" width="80%" wrap-class-name="w-full" :mask-closable="false"
        @ok="handleSubmit" :footer="false" :ok-button-props="{ disabled: disabled || loading, class: 'btn-class' }">
        <div class="grid grid-cols-4 gap-5">
            <EShopInput label="Name" name="name" v-model="productData.name" />
            <EShopInput label="Price" name="price" v-model="productData.price" />
            <div class="mb-5">
                <div class="font-bold mb-2">Discount Availability</div>
                <a-checkbox v-model:checked="productData.discountAvailable">Yes</a-checkbox>
            </div>
            <EShopInput label="Discount Price" name="discountPrice" v-model="productData.discountPrice"
                :disabled="!productData.discountAvailable" />
        </div>
        <div class="grid grid-cols-4 gap-5">
            <div class="col-span-2">
                <div class="mb-2 font-bold"><label>Color</label></div>
                <a-collapse v-model:activeKey="activeKey" :bordered="false">
                    <template #expandIcon="{ isActive }">
                        <caret-right-outlined :rotate="isActive ? 90 : 0" />
                    </template>
                    <a-collapse-panel v-for="(color, idx) of productData.colors" :key="color?.color"
                        :header="allColors.find(cl => cl._id === color.color)?.colorName" :style="customStyle">
                        <EditColor :colorstate="color" :handleUpdateColor="handleColorEdit" :idx="idx"
                            :allColors="allColors" />

                    </a-collapse-panel>
                    <a-collapse-panel key="form" header="ADD" :style="customStyle">
                        <div class="mb-5">
                            <div class="mb-2 font-bold"><label>Color</label></div>
                            <div>
                                <a-select v-model:value="colorState.color" placeholder="Inserted are removed"
                                    class="w-full rounded-lg" size="large">
                                    <a-select-option v-for="color of allColors" :key="color._id" :value="color._id">{{
                                        color.colorName
                                    }}</a-select-option>
                                </a-select>
                            </div>
                        </div>
                        <EShopInput type="number" label="Quantity" v-model="colorState.quantity" />
                        <div class="mb-2">
                            <div class="mb-2 font-bold">Product images</div>
                            <div v-for="url of colorState.images" :key="url" class="inline-block mr-2">
                                <img :src="url" class="h-[150px] w-[100px]" />
                            </div>
                            <div v-if="!colorState.images.length"
                                class="h-[200px] w-[150px] border-dashed border-2 bg-slate-100"></div>
                            <div class="mt-5">
                                <input type="file" multiple :onchange="handleFile" />
                            </div>
                        </div>
                        <EShopButton btn-text="Add" classes="w-full" :onclick="handleAddColor" :disabled="disabledColor" />
                    </a-collapse-panel>
                </a-collapse>
            </div>
            <div class="mb-5">
                <div class="mb-2 font-bold"><label>Brands</label></div>
                <div>
                    <a-select v-model:value="productData.brands" placeholder="Inserted are removed"
                        class="w-full rounded-lg" size="large">
                        <a-select-option v-for="brand of allBrands" :key="brand._id" :value="brand._id">{{
                            brand.name
                        }}</a-select-option>
                    </a-select>
                </div>
            </div>
            <EShopInput label="Quantity" name="quantity" v-model="productData.quantity" />
        </div>
        <div class="grid grid-cols-2 gap-x-5">
            <div class="mb-6">
                <div class="mb-2 font-bold"><label>Description</label></div>
                <div>
                    <quill-editor ref="content" :options="editorOptions" :content="productData?.description" content-type="html"/>
                </div>
            </div>
            <div class="mb-5">
                <div class="font-bold mb-2">New Arrival</div>
                <a-checkbox v-model:checked="productData.newArrival">Yes</a-checkbox>
            </div>
        </div>
        <div class="text-right">
            <button class="mr-3 border-2 px-4 py-1 rounded-lg font-semibold" :onclick="closeModal">Cancel</button>
            <EShopButton :disabled="disabled" :onclick="handleSubmit" btn-text="Update" :loading="loading" />
        </div>
    </a-modal>
</template>

<script setup>
import { ref, toRefs, computed } from 'vue';
import { CaretRightOutlined } from '@ant-design/icons-vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { EShopButton, EShopInput } from '../shared';
import { api, product } from '../../api';
import EditColor from './EditColor.vue';
import { notify } from '../../helpers';

const props = defineProps({
    refetch: Function,
    productDetails: Object,
    allColors: Array,
    allBrands: Array
});
const { refetch, productDetails } = toRefs(props);
const open = ref(false);
const loading = ref(false);
const content = ref(null);

const initialState = {
    name: productDetails.value?.name,
    price: String(productDetails.value?.price),
    discountPrice: String(productDetails.value?.discountPrice),
    discountAvailable: productDetails.value?.discountAvailable,
    quantity: String(productDetails.value?.quantity),
    colors: productDetails.value?.colors,
    description: productDetails.value?.description,
    brands: productDetails.value?.brands?._id,
    newArrival: productDetails?.newArrival
}
const productData = ref({ ...initialState });
const colorState = ref({
    color: '',
    images: [],
    quantity: '0'
})

const disabled = computed(() => !productData.value.name || !productData.value.price || !productData.value.colors.length || !productData.value.brands)
const activeKey = ref(['1']);
const customStyle = 'background: #f7f7f7;border-radius: 4px;margin-bottom: 24px;border: 0;overflow: hidden';


const editorOptions = {
    modules: {
        toolbar: [
            [{ header: '1' }, { header: '2' }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['link'],
            ['clean'],
        ],
    },
};


const handleOpen = () => {
    open.value = true;
}

const closeModal = () => {
    open.value = false;
    productData.value = { ...initialState }
}

// color
const disabledColor = computed(() => !colorState.value.color || !colorState.value.quantity || !colorState.value.images.length)
const handleAddColor = () => {

    let colors = productData.value.colors;
    const { color, images, quantity } = colorState.value;
    colors.push({ color, images, quantity: Number(quantity) });
    productData.value.colors = colors;
    colorState.value = {
        color: "",
        images: [],
        quantity: 0
    }
}

const handleFile = async (e) => {
    let images = colorState.value.images;
    try {
        const files = e.target.files;
        for (var i = 0; i < files.length; i++) {
            const res = await api.fileUpload(files[i]);
            images.push(res.result.url);
        }
        colorState.value.images = images;
    } catch (error) {
        console.log(error)
    }
}


// submit 
const handleSubmit = async () => {
    loading.value = true;
    try {
        const res = await api.put(product.editProduct, productDetails.value._id, { productData: { ...productData.value, description: content.value.getHTML() } });
        notify(res, refetch.value);
        open.value = false
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}


// color edit
const handleColorEdit = (data, idx) => {
    productData.value.colors[idx] = { ...productData.value.colors[idx], ...data };
}

</script>