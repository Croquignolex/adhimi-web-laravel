(function (window, document, $) {
    'use strict';

    const send = $('#send');
    const loader = $('#loader');
    const ins = $('#instruction');
    const chatForm = $('#chat-form');
    const errorAlert = $('#error-alert');

    loader.hide();
    errorAlert.hide();
    const url = chatForm.data('url');
    const name = chatForm.data('name');
    const initials = chatForm.data('initials');

    $('#print').click(() => $('#print-area').printThis({ printDelay: 0}));

    ins.keyup((e) => {
        if (e.keyCode === 13 && !e.shiftKey) {
            chatForm.submit();
        }
    });

    ins.on('input', (e) => {
        const scrollHeight = e.target.scrollHeight;
        chatForm.css({height: scrollHeight + 10});
        ins.css({height: scrollHeight});
    });

    chatForm.submit((e) => {
        e.preventDefault();

        const instruction = ins.val();
        const now = new Date();
        errorAlert.hide();

        if(instruction && instruction.trim() !== "")
        {
            loader.before(buildMessage({
                message: instruction,
                time: `${("0" + now.getHours()).slice(-2) }:${("0" + now.getMinutes()).slice(-2)}`
            }));
            loader.show();

            scroll();
            ins.prop("disabled", true);
            send.prop("disabled", true);

            ajaxRequest(url, 'POST', {instruction})
                .then((response)  => {
                    loader.before(buildMessage(response, true));
                    ins.val("");
                })
                .catch((error) => {
                    errorAlert.show();
                    console.log({error});
                })
                .finally(() => {
                    chatForm.css({height: "60"});
                    ins.css({height: "50"});

                    loader.hide();
                    ins.prop("disabled", false);
                    send.prop("disabled", false);
                    scroll();
                });
        }
    });

    const buildMessage = (data, left = false) => `
        <div class="chat ${left && 'chat-left'}">
            <div class="chat-avatar ${!left && 'text-right'}">
                <div class="avatar ${left ? 'bg-light-primary' : 'bg-light-secondary'} box-shadow-1 cursor-pointer">
                    <span class="avatar-content font-medium-1" title="{{ ${left ? 'ChatGPT' : name} }}">
                        ${left ? 'CG' : initials}
                    </span>
                </div>
            </div>
            <div class="chat-body">
                <div class="chat-content">
                    <div class="${left ? 'text-left' : 'text-right'}">
                        <div class="pre">${escape(data.message)}</div> 
                        ${left ? (`
                            <p class="mt-50">
                                <span class="badge badge-light-secondary">
                                    ${data.time}
                                </span>
                                <span class="badge badge-light-${data.color}">
                                    ${data.badge} 
                                </span>
                            </p>
                        `) : (`
                            <p class="mt-50">
                                <span class="badge badge-light-secondary">
                                    ${data.time}
                                </span>
                            </p>
                        `)}
                    </div>
                </div>
            </div>
        </div>
    `;

    const scroll = () => {
        $('.user-chats').scrollTop($('.user-chats > .chats').height());
        ins.focus();
    };

    const escape = (htmlStr) => {
        return htmlStr.replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#39;");
    };

    setTimeout(() => scroll(), 500);

})(window, document, jQuery);