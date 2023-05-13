@extends('layouts.app')
@section('content')
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body bg-soft-light border border-dashed border-start-0 border-end-0">
                        <div class="grid-margin stretch-card" id="widget-div">
                            <div id="ckfinder-widget">
                                Загрузка ....
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
    </div>
@endsection

@push('script')
    @include('ckfinder::setup')

    <script>

        var clientWidth = document.getElementById('widget-div').clientWidth;

        CKFinder.widget( 'ckfinder-widget', {
            width: clientWidth,
            height: 800,
            startupPath: "Images:/",
            onInit: function( finder ) {
                finder.on( 'toolbar:reset:Main:file', function( evt ) {
                    evt.data.toolbar.push( {
                        type: 'button',
                        priority: 09,
                        label: 'Копировать ссылку',
                        action: function() {
                            evt.finder.request( 'files:getSelected' ).forEach( function( file ) {
                                evt.finder.request( 'file:getUrl', { file: file } )
                                    .then( function( fileUrl ) {
                                        // const path = window.location.pathname+window.location.search
                                        const relativePath = fileUrl.replace(window.location.origin+'/', '');
                                        copyToClipboard('/'+relativePath);
                                    } );
                            } );
                        }
                    } );
                    //
                    evt.data.toolbar.push( {
                        type: 'button',
                        priority: 08,
                        label: 'Копировать полную ссылку',
                        action: function() {
                            evt.finder.request( 'files:getSelected' ).forEach( function( file ) {
                                evt.finder.request( 'file:getUrl', { file: file } )
                                    .then( function( fileUrl ) {
                                        const path = fileUrl.replace(/([^:]\/)\/+/g, "$1");
                                        copyToClipboard(path);
                                    } );
                            } );
                        }
                    } );
                } );
            },

        } );

        const copyToClipboard = str => {
            const el = document.createElement('textarea');  // Create a <textarea> element
            el.value = str;                                 // Set its value to the string that you want copied
            el.setAttribute('readonly', '');                // Make it readonly to be tamper-proof
            el.style.position = 'absolute';
            el.style.left = '-9999px';                      // Move outside the screen to make it invisible
            document.body.appendChild(el);                  // Append the <textarea> element to the HTML document
            const selected =
                document.getSelection().rangeCount > 0        // Check if there is any content selected previously
                    ? document.getSelection().getRangeAt(0)     // Store selection if found
                    : false;                                    // Mark as false to know no selection existed before
            el.select();                                    // Select the <textarea> content
            document.execCommand('copy');                   // Copy - only works as a result of a user action (e.g. click events)
            document.body.removeChild(el);                  // Remove the <textarea> element
            if (selected) {                                 // If a selection existed before copying
                document.getSelection().removeAllRanges();    // Unselect everything on the HTML document
                document.getSelection().addRange(selected);   // Restore the original selection
            }
        };

    </script>

@endpush
