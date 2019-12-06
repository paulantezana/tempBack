document.addEventListener("DOMContentLoaded", () => {

    (() => {
        const SkyGuideTemplate = `<div class="SkyGuide">
            <div class="SkyGuide-cover">{{modal-cover}}</div>
            <div class="SkyGuide-action">
                <span class="SkyGuide-btn">{{modal-map}}</span>
                <span class="SkyGuide-btn">{{modal-title}}</span>
                <span class="SkyGuide-btn">{{modal-close}}</span>
            </div>
            <div class="SkyGuide-scroll">
                <div class="SkyGuide-header">{{modal-header}}</div>
                <div class="SkyGuide-content">{{modal-body}}</div>
            </div>
            <div class="SkyGuide-footer">
                <span class="SkyGuide-page">
                    <span class="SkyGuide-stepVal">{{step-value}}</span>
                    <span class="SkyGuide-stepTotal">{{step-total}}</span>
                </span>
        
                <span class="SkyGuide-btn">{{modal-prev}}</span>
                <span class="SkyGuide-btn">{{modal-next}}</span>
        
                <span class="SkyGuide-btn">{{modal-cancel}}</span>
                <span class="SkyGuide-btn">{{modal-start}}</span>
        
                <span class="SkyGuide-btn">{{modal-first}}</span>
                <span class="SkyGuide-btn">{{modal-continue}}</span>
            </div>
        </div>`;

        const SkyGuideLang = {
            lang: 'es',
            cancelTitle: 'Cancelar',
            cancelText: '×',
            hideText: 'Ocultar',
            tourMapText: '≡',
            tourMapTitle: 'Mapa del gira',
            nextTextDefault: 'Sig',
            prevTextDefault: 'Ant',
            endText: 'Fin',

            modalIntroType: 'Introducción',
            modalContinueType: 'Tour sin terminar',

            contDialogBtnBegin: 'Primero',
            contDialogBtnContinue: 'Continuar',

            introDialogBtnStart: 'Start',
            introDialogBtnCancel: 'Cancelar'
        }

        let view,
            step,
            timer,
            event,
            data = {};

        function getElementByContent(rootElement, text) {
            let filter = {
                acceptNode: function (node) {
                    if (node.nodeType === document.TEXT_NODE && node.nodeValue.includes(text)) {
                        return NodeFilter.FILTER_ACCEPT;
                    }
                    return NodeFilter.FILTER_REJECT;
                }
            }
            let nodes = [];
            let walker = document.createTreeWalker(rootElement, NodeFilter.SHOW_TEXT, filter, false);
            while (walker.nextNode()) {
                nodes.push(walker.currentNode.parentNode);
            }
            return nodes;
        }

        const getLastStandarElement = (elements, classNames = [], content = '') => {
            let lastElement = elements[elements.length - 1];
            lastElement.innerHTML = content;
            classNames.forEach(item => lastElement.classList.add(item));
            return lastElement;
        }

        const saveState = state => {
            window.localStorage.setItem('SkyGuide', JSON.stringify(state));
        }

        let akyGuideModalPos = document.createElement('div');
        akyGuideModalPos.classList.add('skyGuideModal-pos');
        akyGuideModalPos.innerHTML = SkyGuideTemplate;
        document.body.appendChild(akyGuideModalPos);

        let sgModalCover = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{modal-cover}}'), ['sgModal-cover'], '');
        let sgModalTitle = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{modal-title}}'), ['sgModal-title'], '');
        let sgModalMap = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{modal-map}}'), ['sgModal-map'], SkyGuideLang.tourMapText);
        let sgModalClose = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{modal-close}}'), ['sgModal-close'], SkyGuideLang.cancelText);

        let sgModalHeader = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{modal-header}}'), ['sgModal-header'], '');
        let sgModalBody = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{modal-body}}'), ['sgModal-body'], '');

        let sgModalValue = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{step-value}}'), ['sgModal-value'], '');
        let sgModalTotal = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{step-total}}'), ['sgModal-total'], '');

        let sgModalPrev = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{modal-prev}}'), ['sgModal-prev'], SkyGuideLang.prevTextDefault);
        let sgModalNext = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{modal-next}}'), ['sgModal-next'], SkyGuideLang.nextTextDefault);

        let sgModalCancel = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{modal-cancel}}'), ['sgModal-cancel'], SkyGuideLang.introDialogBtnCancel);
        let sgModalStart = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{modal-start}}'), ['sgModal-start'], SkyGuideLang.introDialogBtnStart);

        let sgModalFirst = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{modal-first}}'), ['sgModal-first'], SkyGuideLang.contDialogBtnBegin);
        let sgModalContinue = getLastStandarElement(getElementByContent(akyGuideModalPos, '{{modal-continue}}'), ['sgModal-continue'], SkyGuideLang.contDialogBtnContinue);

        const PaintSkyGuideModal = (modalContent, step, total) => {
            console.log('**PAINT**',step, total);
            if(step === -1){
                sgModalHeader.innerHTML = '';
                sgModalBody.innerHTML = '';
            } else {
                sgModalHeader.innerHTML = modalContent.title;
                sgModalBody.innerHTML = modalContent.content;
    
                if (step === 0) {
                    sgModalPrev.classList.add('sgIsHide');
                    sgModalNext.classList.add('sgIsHide');

                    sgModalCancel.classList.remove('sgIsHide');
                    sgModalStart.classList.remove('sgIsHide');

                    sgModalFirst.classList.add('sgIsHide');
                    sgModalContinue.classList.add('sgIsHide');
                } else {
                    sgModalValue.textContent = step;
                    sgModalTotal.textContent = total;
                    if (step >= total) {
                        sgModalNext.textContent = SkyGuideLang.endText;
                    } else {
                        sgModalNext.textContent = SkyGuideLang.nextTextDefault;
                    }
                    sgModalPrev.classList.remove('sgIsHide');
                    sgModalNext.classList.remove('sgIsHide');

                    sgModalCancel.classList.add('sgIsHide');
                    sgModalStart.classList.add('sgIsHide');

                    sgModalFirst.classList.add('sgIsHide');
                    sgModalContinue.classList.add('sgIsHide');
                }
            }

            saveState({
                view,
                step,
                timer,
                event,
                data,
            });
        }

        const handleRun = options => {
            data = options;
            PaintSkyGuideModal({
                ...data.intro
            }, 0, 0);
        };

        const handleStart = () => {
            console.log('handleStart');
            step = 0;
            PaintSkyGuideModal({
                ...data.steps[step],
            }, step + 1, data.steps.length);
        };

        const handleCancel = () => {
            console.log('handleCancel');
        };

        const handleContinue = () => {
            console.log('handleContinue');
        };

        const handleFirst = () => {
            console.log('handleFirst');
            step = 0;
            PaintSkyGuideModal({
                ...data.steps[step],
            }, step + 1, data.steps.length);
        };

        const handlePrev = () => {
            console.log('handlePrev');
            step = step - 1;
            PaintSkyGuideModal({
                ...data.steps[step],
            }, step + 1, data.steps.length);
        };

        const handleNext = () => {
            console.log('handleNext');
            step = ((data.steps.length - 1) == step) ? step : step  + 1;
            PaintSkyGuideModal({
                ...data.steps[step],
            }, step + 1, data.steps.length);
        };


        sgModalPrev.addEventListener('click', handlePrev);
        sgModalNext.addEventListener('click', handleNext);
        sgModalCancel.addEventListener('click', handleCancel);
        sgModalStart.addEventListener('click', handleStart);
        sgModalFirst.addEventListener('click', handleFirst);
        sgModalContinue.addEventListener('click', handleContinue);

        let SkyGuide = {
            run(options){
                handleRun(options);
            }
        }

        window.SkyGuide = SkyGuide;
    })();


    let data = {
        tourId: '1',
        intro: {
            enable: true,
            cover: '',
            title: 'Welcome to the interactive tour',
            content: 'This tour will tell you about the main site functionalities',
            width: false,
        },
        continue: {
            enable: true,
            cover: '',
            title: 'Welcome to the interactive tour',
            content: 'This tour will tell you about the main site functionalities',
            width: false,
        },
        steps: [
            {
                title: 'New Step Title 1',
                content: 'New Step Description 1',
            },
            {
                title: 'New Step Title 2',
                content: 'New Step Description 2',
            },
            {
                title: 'New Step Title 3',
                content: 'New Step Description 3',
            },
            {
                title: 'New Step Title 4',
                content: 'New Step Description 4',
            },
            {
                title: 'New Step Title 5',
                content: 'New Step Description 5',
            },
            {
                title: 'New Step Title 6',
                content: 'New Step Description 6',
            },
        ],
    }

    SkyGuide.run(data);
});








//let runescape = new RegExp("\\\\[\\da-fA-F]{1,6}" + whitespace + "?|\\\\([^\\r\\n\\f])", "g");














