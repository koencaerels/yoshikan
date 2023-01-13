<template>
    <div id="dialogChangeProfileImage" style="width:700px;">

        <div class="flex flex-row">
            <div class="basis-1/2">
                <div v-if="memberStore.memberDetail">
                    <Dropdown
                        placeholder="kies een foto uit de lijst"
                        class="w-full"
                        v-model="selectedImageId"
                        option-value="id"
                        :options="memberStore.memberDetail.images"
                        option-label="originalName"/>
                </div>
                <div class="mt-2 text-right">
                    <Button label="Preview"
                            icon="pi pi-eye"
                            @click="crop"
                            class="p-button-sm"/>
                </div>
                <div id="cropperWrapper" class="mt-2">
                    <cropper
                        ref="cropper"
                        class="cropper"
                        :src="'http://localhost.charlesproxy.com:8080/mm/api/member/member-image/'+selectedImageId+'/stream'"
                        :stencil-props="{
                            handlers: {},
                            scalable: true,
                            movable:false,
                            aspectRatio: 1,
                        }"
                        :stencil-size="{
                            width: 300,
                            height: 300
                        }"
                        :resize-image="{
                            adjustStencil: false
                        }"
                        image-restriction="stencil"
                        :canvas="{
                            height: 300,
                            width: 300
                        }"
                    />
                </div>
            </div>
            <div class="basis-1/2 ml-4">
                <div>
                    <br><br>&nbsp;
                </div>
                <div class="border-[1px] border-black mt-6" style="width:300px;height:300px;">
                    <img :src="image" style="width:300px;height:300px;"/>
                </div>
                <div class="mt-1">
                    <Button v-if="!isSaving"
                            @click="save"
                            label="Bewaar"
                            icon="pi pi-save"
                            class="p-button-sm p-button-success"/>
                    <Button v-if="isSaving"
                            label="Bewaar"
                            disabled
                            icon="pi pi-spinner pi-spin"
                            class="p-button-sm p-button-success"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Cropper} from 'vue-advanced-cropper';
import {useMemberStore} from "@/store/member";
import {mapStores} from "pinia";
import {uploadProfileImage} from "@/api/command/uploadProfileImage";

export default {
    components: {
        Cropper,
    },
    computed: {
        ...mapStores(useMemberStore),
    },
    data() {
        return {
            coordinates: {
                width: 0,
                height: 0,
                left: 0,
                top: 0,
            },
            image: null,
            selectedImageId: 0,
            isSaving: false,
        };
    },
    methods: {
        crop() {
            const {coordinates, canvas,} = this.$refs.cropper.getResult();
            this.coordinates = coordinates;
            this.image = canvas.toDataURL();
        },
        save() {
            this.isSaving = true;
            const {coordinates, canvas,} = this.$refs.cropper.getResult();
            canvas.toBlob(async blob => {
                let command = {
                    id: this.memberStore.memberId,
                    imageBlob: blob
                }
                await uploadProfileImage(command);
                this.isSaving = false;
                this.$emit('saved');

            },'image/png');
        }
    },
};

</script>

<style>

.cropper {
    display: block;
    width: 350px;
}

#cropperWrapper {
    max-width: 350px;
    height: 700px;
}

</style>
