namespace pages {

    export class share_video extends Bootstrap {

        public get appName(): string {
            return "share_video"
        };

        private get upload_url(): string {
            return <any>$ts("@api:upload");
        }

        protected init(): void {
            let vm = this;

            /* global $, window */
            (<any>$('#fileupload')).fileupload({
                stop: function (e, data) {
                    vm.stop(e, data);
                },
                change: function (e, data) {
                    vm.change(e, data);
                },
                add: function (e, data) {
                    vm.add(e, data, $(this));
                },
                getFilesFromResponse: function (e) {
                    vm.getFilesFromResponse(e);
                }
            });
        }

        stop(e, data) {
            TypeScript.logging.log("Stop!", TypeScript.ConsoleColors.Red);
        }

        change(e, data) {
            TypeScript.logging.log("Changed!", TypeScript.ConsoleColors.Green);
        }

        getFilesFromResponse(e: { result: IMsg<string>, files: any[] }) {         
            let code = e.result.code;
            let result = e.result.info;

            if (code == 0) {
                layer.msg(result, { icon: 1 }, function () {
                    parent.location.reload();
                });
            } else {
                layer.msg(result, { icon: 5 }, function () {

                });
            }

            if (e.result && $.isArray(e.files)) {
                return e.files;
            }
        }

        add(e, data: {
            files: any[],
            context: any,
            process: any,
            autoUpload: boolean,
            submit: Delegate.Action
        }, fileUploader) {

            let acceptFileTypes = /^file\/(mp4)$/i;
            let file_err = false;

            // 文件类型判断
            (data.files).map(function (index) {
                if (index.type.length && !acceptFileTypes.test(index.type)) {
                    file_err = true;
                }
            });
            if (file_err) {
                layer.msg('请上传MP4视频文件！', { icon: 0 });
                return false;
            }

            TypeScript.logging.log(this.upload_url, TypeScript.ConsoleColors.Blue);

            // 动态修改文件上传的url参数
            fileUploader.fileupload('option', 'url', this.upload_url);
            // 将文件添加到上传列表中显示
            let $this = fileUploader,
                that = $this.data('blueimp-fileupload') || $this.data('fileupload'),
                options = that.options;
            data.context = that._renderUpload(data.files)
                .data('data', data)
                .addClass('processing');
            options.filesContainer[
                options.prependFiles ? 'prepend' : 'append'
            ](data.context);
            that._forceReflow(data.context);
            that._transition(data.context);

            data.process(function () {
                return $this.fileupload('process', data);
            }).always(function () {
                data.context.each(function (index) {
                    $(this).find('.size').text(
                        that._formatFileSize(data.files[index].size)
                    );

                }).removeClass('processing');

                that._renderPreviews(data);
            }).done(function () {
                data.context.find('.start').prop('disabled', false);

                if ((that._trigger('added', e, data) !== false) &&
                    (options.autoUpload || data.autoUpload) &&
                    data.autoUpload !== false) {
                    data.submit();
                }
            });
        }
    }
}