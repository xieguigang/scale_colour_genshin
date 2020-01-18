namespace webapp {

    export function hookImagePreviews(inputId: string, previewImgId: string) {
        let image = $image(previewImgId);
        let file: File;

        $input(inputId).onchange = function (this, evt) {
            file = $input(inputId).files[0];
            image.src = URL.createObjectURL(file);
        }
    }
}