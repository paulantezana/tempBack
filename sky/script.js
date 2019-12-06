var SkyGuide;

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

    const getState = () => {
        let skyGuide = window.localStorage.getItem('SkyGuide');
        return skyGuide != null ? JSON.parse(skyGuide) : null;
    }

    const destroyState = () => {
        window.localStorage.removeItem('SkyGuide');
    }

    SkyGuide = (options = null) => {
        let step,   // 1 - 2 - 3 - 4
            event,  // create || start
            data = {};
        if (getState() == null && options == null) {
            return;
        }

        if (getState() != null) {
            let oldState = getState();
            step = oldState.step;
            event = oldState.event;
            data = oldState.data;
        } else {
            step = 0;
            event = 'create';
            data = options;
        }

        let skyGuideOverLay = document.createElement('div');
        skyGuideOverLay.classList.add('SkyGuide-overlay');

        let skyGuideModalPos = document.createElement('div');
        skyGuideModalPos.classList.add('SkyGuide-wrapper');

        document.body.appendChild(skyGuideOverLay);
        document.body.appendChild(skyGuideModalPos);

        skyGuideModalPos.innerHTML = SkyGuideTemplate;
        let sgModalCover = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{modal-cover}}'), ['sgModal-cover'], '');
        let sgModalTitle = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{modal-title}}'), ['sgModal-title'], '');
        let sgModalMap = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{modal-map}}'), ['sgModal-map'], SkyGuideLang.tourMapText);
        let sgModalClose = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{modal-close}}'), ['sgModal-close'], SkyGuideLang.cancelText);

        let sgModalHeader = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{modal-header}}'), ['sgModal-header'], '');
        let sgModalBody = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{modal-body}}'), ['sgModal-body'], '');

        let sgModalValue = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{step-value}}'), ['sgModal-value'], '');
        let sgModalTotal = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{step-total}}'), ['sgModal-total'], '');

        let sgModalPrev = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{modal-prev}}'), ['sgModal-prev'], SkyGuideLang.prevTextDefault);
        let sgModalNext = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{modal-next}}'), ['sgModal-next'], SkyGuideLang.nextTextDefault);

        let sgModalCancel = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{modal-cancel}}'), ['sgModal-cancel'], SkyGuideLang.introDialogBtnCancel);
        let sgModalStart = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{modal-start}}'), ['sgModal-start'], SkyGuideLang.introDialogBtnStart);

        let sgModalFirst = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{modal-first}}'), ['sgModal-first'], SkyGuideLang.contDialogBtnBegin);
        let sgModalContinue = getLastStandarElement(getElementByContent(skyGuideModalPos, '{{modal-continue}}'), ['sgModal-continue'], SkyGuideLang.contDialogBtnContinue);

        const PaintSkyGuideModal = (modalContent, step, total) => {
            console.log('**PAINT**', step, total);
            if (step === -1) {
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

                    saveState({
                        step,
                        event,
                        data,
                    });
                }
            }
        }

        const destroyGuide = () => {
            skyGuideOverLay.remove();
            skyGuideModalPos.remove();
            destroyState();
        }

        console.log(step);

        if(step >= 1){
            PaintSkyGuideModal({
                ...data.steps[step - 1],
            }, step, data.steps.length);
        } else {
            PaintSkyGuideModal({
                ...data.intro,
            }, 0, 0);
        }

        const handleStart = () => {
            step = 1;
            PaintSkyGuideModal({
                ...data.steps[step - 1],
            }, step, data.steps.length);
        };

        const handleCancel = () => {
            destroyGuide();
        };

        const handleContinue = () => {
            console.log('handleContinue');
        };

        const handleFirst = () => {
            step = 1;
            PaintSkyGuideModal({
                ...data.steps[step-1],
            }, step, data.steps.length);
        };

        const handlePrev = () => {
            step = step - 1;
            PaintSkyGuideModal({
                ...data.steps[step-1],
            }, step, data.steps.length);
        };

        const handleNext = () => {
            if(data.steps.length == step){
                step = 0;
                destroyGuide();
            } else {
                step = step + 1;
                PaintSkyGuideModal({
                    ...data.steps[step-1],
                }, step, data.steps.length);
            }
        };


        sgModalClose.addEventListener('click', handleCancel);
        sgModalPrev.addEventListener('click', handlePrev);
        sgModalNext.addEventListener('click', handleNext);
        sgModalCancel.addEventListener('click', handleCancel);
        sgModalStart.addEventListener('click', handleStart);
        sgModalFirst.addEventListener('click', handleFirst);
        sgModalContinue.addEventListener('click', handleContinue);
    }

    document.addEventListener("DOMContentLoaded", () => {
        SkyGuide();
    });
})();


// Use app
document.addEventListener("DOMContentLoaded", () => {
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


    let StartExample = document.getElementById('StartExample');
    StartExample.addEventListener('click', () => {
        SkyGuide(data);
    });
});