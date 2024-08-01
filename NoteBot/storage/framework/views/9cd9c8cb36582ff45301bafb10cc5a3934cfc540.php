
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('partials/navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('partials/notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="loader-container">
        <div class="loader"></div>
    </div>

    <style>
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .loader {
            width: 100px;
            height: 75px;
            background-image: url(http://127.0.0.1:8000/uploads/loader.gif);
            background-size: auto;
            background-repeat: no-repeat;
            border-radius: 10px;
            background-size: contain;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #output {
            color: white;
            font-size: 18px;
        }

        .notification {
            z-index: 99999999 !important;
        }

        .select2 {
            width: 100% !important;
        }

        .tox .tox-menubar,
        .tox-editor-header,
        .tox .tox-mbtn,
        .tox .tox-menubar,
        /* .tox:not(.tox-tinymce-inline) .tox-editor-header, */
        .tox .tox-toolbar,
        .tox .tox-toolbar__overflow,
        .tox .tox-toolbar__primary,
        .tox .tox-toolbar-overlord,
        .tox .tox-edit-area__iframe,
        .tox .tox-tbtn {
            background-color: #f0f0f0 !important;
        }

        .tox-toolbar__primary {
            padding: 0px 20px !important;
        }

        .tox-statusbar {
            display: none !important;
        }

        .notification {
            position: fixed;
            bottom: 20px;
            right: 40px;
            background-color: #4CAF50;
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.5s;
        }

        .share-button {
            position: fixed;
            bottom: 20px;
            left: 40px;
            width: 50px;
            height: 50px;
            cursor: pointer;
            background-image: url('https://cdn3.iconfinder.com/data/icons/social-messaging-ui-color-line/254002/174-512.png');
            background-size: cover;
        }
    </style>
    <?php
        $book_id = $book->id;
    ?>
    <script src="https://cdn.tiny.cloud/1/o9g17apj7kmskvkthmya4zmtfbkkzca2kux2sqao86loc5y0/tinymce/7/tinymce.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>

    <div class="textarea_container m-5">
        <textarea id="tinymceTextarea"><?php echo e(isset($book->content->content) ? $book->content->content : ''); ?></textarea>
        <div class="notification" id="notification"></div>
    </div>
    <div class="share-button" onclick="copyToClipboard('<?php echo e(route('share')); ?>?book=<?php echo e($_GET['book']); ?>')"></div>


    <div class="modal fade" id="recordaudiomodal" tabindex="-1" aria-labelledby="addbooklabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addbooklabel">Record Voice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <audio id="recorder" muted hidden></audio>
                    <div style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 20px;">
                        <button class="theme-button" id="start">Record</button>
                        <button class="theme-button" style="display: none" id="stop">Stop Recording</button>
                    </div>
                    <div style="display: none" class="player-body">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 20px;">
                            <audio style="" id="player" controls></audio>
                            <div id="saveButton" class="theme-button">Save</div>
                        </div>
                    </div>
                </div>
                <script>
                    class VoiceRecorder {
                        constructor() {
                            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                                console.log("getUserMedia supported")
                            } else {
                                console.log("getUserMedia is not supported on your browser!")
                            }

                            this.mediaRecorder
                            this.stream
                            this.chunks = []
                            this.isRecording = false

                            this.recorderRef = document.querySelector("#recorder")
                            this.playerRef = document.querySelector("#player")
                            this.startRef = document.querySelector("#start")
                            this.stopRef = document.querySelector("#stop")

                            this.startRef.onclick = this.startRecording.bind(this)
                            this.stopRef.onclick = this.stopRecording.bind(this)

                            this.constraints = {
                                audio: true,
                                video: false
                            }

                        }

                        handleSuccess(stream) {
                            this.stream = stream
                            this.stream.oninactive = () => {
                                console.log("Stream ended!")
                            };
                            this.recorderRef.srcObject = this.stream
                            this.mediaRecorder = new MediaRecorder(this.stream)
                            console.log(this.mediaRecorder)
                            this.mediaRecorder.ondataavailable = this.onMediaRecorderDataAvailable.bind(this)
                            this.mediaRecorder.onstop = this.onMediaRecorderStop.bind(this)
                            this.recorderRef.play()
                            this.mediaRecorder.start()
                        }

                        handleError(error) {
                            console.log("navigator.getUserMedia error: ", error)
                        }

                        onMediaRecorderDataAvailable(e) {
                            this.chunks.push(e.data)
                        }

                        onMediaRecorderStop(e) {
                            const blob = new Blob(this.chunks, {
                                'type': 'audio/ogg; codecs=opus'
                            })
                            const audioURL = window.URL.createObjectURL(blob)
                            this.playerRef.src = audioURL
                            this.chunks = []
                            this.stream.getAudioTracks().forEach(track => track.stop())
                            this.stream = null
                        }

                        startRecording() {
                            $('.player-body').hide();
                            $('#stop').show();
                            if (this.isRecording) return
                            this.isRecording = true
                            this.startRef.innerHTML = 'Recording...'
                            this.playerRef.src = ''
                            navigator.mediaDevices
                                .getUserMedia(this.constraints)
                                .then(this.handleSuccess.bind(this))
                                .catch(this.handleError.bind(this))
                        }

                        stopRecording() {
                            $('.player-body').show();
                            if (!this.isRecording) return
                            this.isRecording = false
                            this.startRef.innerHTML = 'Record'
                            this.recorderRef.pause()
                            this.mediaRecorder.stop()
                        }

                    }

                    window.voiceRecorder = new VoiceRecorder()
                    $(document).on('click', '#saveButton', function() {
                        let fileBlob = $('#player').attr('src');

                        fetch(fileBlob)
                            .then(response => response.blob())
                            .then(blob => {
                                let formData = new FormData();
                                formData.append('audio', blob);
                                formData.append('content', "<?php echo e($book->content->id); ?>");
                                formData.append('_token', "<?php echo e(csrf_token()); ?>");

                                $.ajax({
                                    type: 'POST',
                                    url: "<?php echo e(route('save-audio')); ?>",
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    cache: false,
                                    success: function(response) {
                                        if (response.html) {
                                            let tinymceInstance = tinymce.get('tinymceTextarea');
                                            tinymceInstance.setContent(response.html);
                                            showNotification('Saved');
                                            saveContent(response.html);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error sending audio file:', error);
                                    }
                                });
                            })
                            .catch(error => console.error('Error:', error));
                    });
                </script>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addcodemodal" tabindex="-1" aria-labelledby="addbooklabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addbooklabel">Add Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="code_editor_container m-1">
                    <style>
                        #code_editor {
                            position: relative;
                            height: 400px;
                            width: 100%;
                        }
                    </style>
                    <label for="mode">Select Language</label>
                    <br>
                    <select id="mode" class="mb-3 w-100" size="1">
                        <option value="ace/mode/abap">abap</option>
                        <option value="ace/mode/actionscript">actionscript</option>
                        <option value="ace/mode/ada">ada</option>
                        <option value="ace/mode/asciidoc">asciidoc</option>
                        <option value="ace/mode/assembly_x86">assembly_x86</option>
                        <option value="ace/mode/autohotkey">autohotkey</option>
                        <option value="ace/mode/batchfile">batchfile</option>
                        <option value="ace/mode/c9search">c9search</option>
                        <option value="ace/mode/c_cpp">c_cpp</option>
                        <option value="ace/mode/c_cpp">c_cpp</option>
                        <option value="ace/mode/clojure">clojure</option>
                        <option value="ace/mode/cobol">cobol</option>
                        <option value="ace/mode/coffee">coffee</option>
                        <option value="ace/mode/coldfusion">coldfusion</option>
                        <option value="ace/mode/csharp">csharp</option>
                        <option value="ace/mode/css">css</option>
                        <option value="ace/mode/curly">curly</option>
                        <option value="ace/mode/d">d</option>
                        <option value="ace/mode/dart">dart</option>
                        <option value="ace/mode/diff">diff</option>
                        <option value="ace/mode/django">django</option>
                        <option value="ace/mode/dot">dot</option>
                        <option value="ace/mode/ejs">ejs</option>
                        <option value="ace/mode/erlang">erlang</option>
                        <option value="ace/mode/forth">forth</option>
                        <option value="ace/mode/ftl">ftl</option>
                        <option value="ace/mode/glsl">glsl</option>
                        <option value="ace/mode/golang">golang</option>
                        <option value="ace/mode/groovy">groovy</option>
                        <option value="ace/mode/haml">haml</option>
                        <option value="ace/mode/handlebars">handlebars</option>
                        <option value="ace/mode/haskell">haskell</option>
                        <option value="ace/mode/haxe">haxe</option>
                        <option value="ace/mode/html">html</option>
                        <option value="ace/mode/html_ruby">html_ruby</option>
                        <option value="ace/mode/ini">ini</option>
                        <option value="ace/mode/jade">jade</option>
                        <option value="ace/mode/java">java</option>
                        <option value="ace/mode/javascript" selected>javascript</option>
                        <option value="ace/mode/json">json</option>
                        <option value="ace/mode/jsoniq">jsoniq</option>
                        <option value="ace/mode/jsp">jsp</option>
                        <option value="ace/mode/jsx">jsx</option>
                        <option value="ace/mode/julia">julia</option>
                        <option value="ace/mode/latex">latex</option>
                        <option value="ace/mode/less">less</option>
                        <option value="ace/mode/liquid">liquid</option>
                        <option value="ace/mode/lisp">lisp</option>
                        <option value="ace/mode/livescript">livescript</option>
                        <option value="ace/mode/logiql">logiql</option>
                        <option value="ace/mode/lsl">lsl</option>
                        <option value="ace/mode/lua">lua</option>
                        <option value="ace/mode/luapage">luapage</option>
                        <option value="ace/mode/lucene">lucene</option>
                        <option value="ace/mode/makefile">makefile</option>
                        <option value="ace/mode/markdown">markdown</option>
                        <option value="ace/mode/matlab">matlab</option>
                        <option value="ace/mode/mushcode">mushcode</option>
                        <option value="ace/mode/mushcode_high_rules">mushcode_high_rules</option>
                        <option value="ace/mode/mysql">mysql</option>
                        <option value="ace/mode/objectivec">objectivec</option>
                        <option value="ace/mode/ocaml">ocaml</option>
                        <option value="ace/mode/pascal">pascal</option>
                        <option value="ace/mode/perl">perl</option>
                        <option value="ace/mode/pgsql">pgsql</option>
                        <option value="ace/mode/php">php</option>
                        <option value="ace/mode/powershell">powershell</option>
                        <option value="ace/mode/prolog">prolog</option>
                        <option value="ace/mode/properties">properties</option>
                        <option value="ace/mode/python">python</option>
                        <option value="ace/mode/r">r</option>
                        <option value="ace/mode/rdoc">rdoc</option>
                        
                        <option value="ace/mode/ruby">ruby</option>
                        <option value="ace/mode/rust">rust</option>
                        <option value="ace/mode/sass">sass</option>
                        <option value="ace/mode/scad">scad</option>
                        <option value="ace/mode/scala">scala</option>
                        <option value="ace/mode/scheme">scheme</option>
                        <option value="ace/mode/scss">scss</option>
                        <option value="ace/mode/sh">sh</option>
                        <option value="ace/mode/snippets">snippets</option>
                        <option value="ace/mode/sql">sql</option>
                        <option value="ace/mode/stylus">stylus</option>
                        <option value="ace/mode/svg">svg</option>
                        <option value="ace/mode/tcl">tcl</option>
                        <option value="ace/mode/tex">tex</option>
                        <option value="ace/mode/text">text</option>
                        <option value="ace/mode/textile">textile</option>
                        <option value="ace/mode/toml">toml</option>
                        <option value="ace/mode/twig">twig</option>
                        <option value="ace/mode/typescript">typescript</option>
                        <option value="ace/mode/vbscript">vbscript</option>
                        <option value="ace/mode/velocity">velocity</option>
                        <option value="ace/mode/verilog">verilog</option>
                        <option value="ace/mode/xml">xml</option>
                        <option value="ace/mode/xquery">xquery</option>
                        <option value="ace/mode/yaml">yaml</option>
                    </select>
                    <br><br>
                    <div id="code_editor">console.log('NotBot is here')</div>
                    <button class="theme-button m-3"
                        style="width: 100%;margin: 0px !important;padding: 10px !important;margin-top: 15px !important; margin-bottom: 15px !important;"
                        id="copyButton">Add Code</button> <!-- Button to copy the code -->

                </div>

            </div>
        </div>
    </div>



    <div class="modal fade" id="addaudiomodal" tabindex="-1" aria-labelledby="addbooklabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addbooklabel">Add Voice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>



            </div>
        </div>
    </div>

    <p id="output"></p>
    <script>
        $(document).ready(function() {
            if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
                const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
                recognition.lang = 'en-US';
                recognition.interimResults = false;

                recognition.onstart = function() {
                    console.log('Start');
                    $('.loader-container').show();
                    $('.textarea_container').hide();
                };
                recognition.onend = function() {
                    console.log('Stop');
                    $('.loader-container').hide();
                    $('.textarea_container').show();

                };
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;

                    showNotification('You said: ' + transcript);

                    let tinymceInstance = tinymce.get('tinymceTextarea');


                    let existingContent = tinymceInstance.getContent({
                        format: 'HTML'
                    });

                    // Append the new code with <pre> tags to the existing content
                    var updatedContent = existingContent + '<p>' + transcript + '</p><br>';

                    // Set the updated content back to the TinyMCE editor
                    tinymceInstance.setContent(updatedContent);



                    showNotification('Saved');

                    // Save the updated content
                    saveContent(updatedContent);






                };

                $(document).on('click', '#startButton', function() {

                    recognition.start();
                });
            } else {
                console.log('Speech recognition not supported in this browser.');
            }
        });
    </script>
    <script>
        function addBlocks() {
            $('.tox-toolbar__primary').append(
                `<button id="startButton" style="cursor:pointer; margin-right: 15px;">Start Voice Recognition</button>`
            );

            $('.tox-toolbar__primary').append(
                `<button id="start_speech" style="cursor:pointer; margin-right: 15px;">Generate Voice</button>`
            );
            $('.tox-toolbar__primary').append(
                `<a href="#" class="d-flex" data-toggle="modal" data-target="#addcodemodal"><button style="cursor:pointer; margin-right: 15px;">Add Code</button></a>`
            );

            $('.tox-toolbar__primary').append(
                `<a href="#" class="d-flex" data-toggle="modal" data-target="#recordaudiomodal"><button id="recordVoice" style="cursor:pointer; margin-right: 15px;">Record Audio</button></a>`
            );
            $('.tox-toolbar__primary').append(` <select id="languageSelect">
        <option value="">Translation</option>
        <option value="af">Afrikaans</option>
        <option value="sq">Albanian</option>
        <option value="am">Amharic</option>
        <option value="ar">Arabic</option>
        <option value="hy">Armenian</option>
        <option value="az">Azerbaijani</option>
        <option value="eu">Basque</option>
        <option value="be">Belarusian</option>
        <option value="bn">Bengali</option>
        <option value="bs">Bosnian</option>
        <option value="bg">Bulgarian</option>
        <option value="ca">Catalan</option>
        <option value="ceb">Cebuano</option>
        <option value="ny">Chichewa</option>
        <option value="zh-CN">Chinese (Simplified)</option>
        <option value="zh-TW">Chinese (Traditional)</option>
        <option value="co">Corsican</option>
        <option value="hr">Croatian</option>
        <option value="cs">Czech</option>
        <option value="da">Danish</option>
        <option value="nl">Dutch</option>
        <option value="en">English</option>
        <option value="eo">Esperanto</option>
        <option value="et">Estonian</option>
        <option value="tl">Filipino</option>
        <option value="fi">Finnish</option>
        <option value="fr">French</option>
        <option value="fy">Frisian</option>
        <option value="gl">Galician</option>
        <option value="ka">Georgian</option>
        <option value="de">German</option>
        <option value="el">Greek</option>
        <option value="gu">Gujarati</option>
        <option value="ht">Haitian Creole</option>
        <option value="ha">Hausa</option>
        <option value="haw">Hawaiian</option>
        <option value="iw">Hebrew</option>
        <option value="hi">Hindi</option>
        <option value="hmn">Hmong</option>
        <option value="hu">Hungarian</option>
        <option value="is">Icelandic</option>
        <option value="ig">Igbo</option>
        <option value="id">Indonesian</option>
        <option value="ga">Irish</option>
        <option value="it">Italian</option>
        <option value="ja">Japanese</option>
        <option value="jw">Javanese</option>
        <option value="kn">Kannada</option>
        <option value="kk">Kazakh</option>
        <option value="km">Khmer</option>
        <option value="rw">Kinyarwanda</option>
        <option value="ko">Korean</option>
        <option value="ku">Kurdish (Kurmanji)</option>
        <option value="ky">Kyrgyz</option>
        <option value="lo">Lao</option>
        <option value="la">Latin</option>
        <option value="lv">Latvian</option>
        <option value="lt">Lithuanian</option>
        <option value="lb">Luxembourgish</option>
        <option value="mk">Macedonian</option>
        <option value="mg">Malagasy</option>
        <option value="ms">Malay</option>
        <option value="ml">Malayalam</option>
        <option value="mt">Maltese</option>
        <option value="mi">Maori</option>
        <option value="mr">Marathi</option>
        <option value="mn">Mongolian</option>
        <option value="my">Myanmar (Burmese)</option>
        <option value="ne">Nepali</option>
        <option value="no">Norwegian</option>
        <option value="ps">Pashto</option>
        <option value="fa">Persian</option>
        <option value="pl">Polish</option>
        <option value="pt">Portuguese</option>
        <option value="pa">Punjabi</option>
        <option value="ro">Romanian</option>
        <option value="ru">Russian</option>
        <option value="sm">Samoan</option>
        <option value="gd">Scots Gaelic</option>
        <option value="sr">Serbian</option>
        <option value="st">Sesotho</option>
        <option value="sn">Shona</option>
        <option value="sd">Sindhi</option>
        <option value="si">Sinhala</option>
        <option value="sk">Slovak</option>
        <option value="sl">Slovenian</option>
        <option value="so">Somali</option>
        <option value="es">Spanish</option>
        <option value="su">Sundanese</option>
        <option value="sw">Swahili</option>
        <option value="sv">Swedish</option>
        <option value="tg">Tajik</option>
        <option value="ta">Tamil</option>
        <option value="te">Telugu</option>
        <option value="th">Thai</option>
        <option value="tr">Turkish</option>
        <option value="uk">Ukrainian</option>
        <option value="ur">Urdu</option>
        <option value="ug">Uyghur</option>
        <option value="uz">Uzbek</option>
        <option value="vi">Vietnamese</option>
        <option value="cy">Welsh</option>
        <option value="xh">Xhosa</option>
        <option value="yi">Yiddish</option>
        <option value="yo">Yoruba</option>
        <option value="zu">Zulu</option>
    </select>`);

        }



        function showNotification(message) {
            var notification = document.getElementById('notification');
            notification.textContent = message;
            notification.style.opacity = '1';
            setTimeout(function() {
                notification.style.opacity = '0';
            }, 4000);
        }


        function translateHTML(htmlContent, targetLanguage) {
            // Split HTML content into text segments and HTML tags
            let segments = htmlContent.match(/(<[^>]*>|[^<]+)/g);

            // Translate each text segment individually
            let translatedSegments = segments.map(function(segment) {
                // Skip HTML tags
                if (segment.startsWith('<')) {
                    return segment;
                } else {
                    // Translate text segment
                    let sanitizedSegment = segment.replace(/\n/g, ' ');
                    let encodedSegment = encodeURIComponent(sanitizedSegment);
                    let apiUrl =
                        "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=" +
                        targetLanguage + "&dt=t&q=" + encodedSegment;
                    return fetch(apiUrl)
                        .then(response => response.json())
                        .then(data => {
                            return data[0][0][0];
                        })
                        .catch(error => {

                            return segment; // Return original segment if translation fails
                        });
                }
            });

            // Wait for all translations to complete
            return Promise.all(translatedSegments)
                .then(function(translatedSegments) {
                    // Reconstruct HTML content with translated text segments
                    return translatedSegments.join('');
                });
        }

        function copyToClipboard(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            showNotification('Share Link Copied to Clipboard');
        }

        function saveContent(content) {
            $.ajax({
                url: "<?php echo e(route('save-book')); ?>",
                method: 'POST',
                data: {
                    book: '<?php echo e($_GET['book']); ?>',
                    content: content,
                    '_token': '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    showNotification('Saved');
                },
                error: function(xhr, status, error) {

                }
            });
        }

        $(document).ready(function() {
            let timeout = null;
            tinymce.init({
                selector: 'textarea',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker markdown',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                height: '70vh',
                setup: function(editor) {
                    editor.on('keyup', function(e) {

                        clearTimeout(timeout);

                        timeout = setTimeout(function() {
                            saveContent(editor.getContent());
                        }, 1000);
                    });
                }

            });



            var code_editor = ace.edit("code_editor");
            code_editor.getSession().setUseWorker(false);
            code_editor.setTheme("ace/theme/monokai");
            code_editor.getSession().setMode("ace/mode/javascript");

            $("#mode").on("change", function(ev) {
                var mode = $(this).val();
                code_editor.getSession().setMode(mode);
            });
            // $('#mode').select2();
            // $('#languageSelect').select2();


            let tinymceInstance = tinymce.get('tinymceTextarea');



            document.getElementById("copyButton").addEventListener("click", function() {
                let code_formatted = code_editor.getValue();

                // Get existing content of TinyMCE editor
                var existingContent = tinymceInstance.getContent({
                    format: 'HTML'
                });
                let selected_language = $("#mode option:selected").html();

                // Append the new code with <pre> tags to the existing content
                var updatedContent = existingContent +
                    '<small     style="background: #302d42;padding: 7px;color: white;width: max-content;border-radius: 5px;">' +
                    selected_language + ' Code</small><pre>' + code_formatted + '</pre><br>';

                // Set the updated content back to the TinyMCE editor
                tinymceInstance.setContent(updatedContent);

                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');
                showNotification('Code has been added');

                // Save the updated content
                saveContent(updatedContent);
            });



            $(document).on('change', '#languageSelect', function() {
                let htmlContent = tinymce.get('tinymceTextarea').getContent({
                    format: 'HTML'
                });
                if (htmlContent) {
                    translateHTML(htmlContent, $(this).val())
                        .then(translatedHTML => {
                            tinymceInstance.setContent(translatedHTML);
                            saveContent(translatedHTML);
                        });
                }
            });

            $(document).on('click', '#start_speech', function() {
                let text = tinymce.get('tinymceTextarea').getContent({
                    format: 'text'
                });
                console.log(text);

                // Check if the browser supports the SpeechSynthesis API
                if ('speechSynthesis' in window) {
                    // Create a new SpeechSynthesisUtterance object with the text
                    let utterance = new SpeechSynthesisUtterance(text);

                    // Set additional parameters if needed
                    // utterance.volume = 1; // Volume level (0 to 1)
                    // utterance.rate = 1;   // Speed rate (0.1 to 10)
                    // utterance.pitch = 1;  // Pitch level (0 to 2)

                    // Speak the text
                    window.speechSynthesis.speak(utterance);
                } else {
                    // Browser doesn't support SpeechSynthesis API
                    alert("Sorry, your browser doesn't support text-to-speech functionality.");
                }
            });











            setTimeout(function() {
                addBlocks();
            }, 2000);














        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout/layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\final_year_project\resources\views/viewBook.blade.php ENDPATH**/ ?>