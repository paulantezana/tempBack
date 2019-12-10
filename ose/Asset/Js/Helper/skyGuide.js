((w, d) => {
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
                if (node.nodeType === d.TEXT_NODE && node.nodeValue.includes(text)) {
                    return NodeFilter.FILTER_ACCEPT;
                }
                return NodeFilter.FILTER_REJECT;
            }
        }
        let nodes = [];
        let walker = d.createTreeWalker(rootElement, NodeFilter.SHOW_TEXT, filter, false);
        while (walker.nextNode()) {
            nodes.push(walker.currentNode.parentNode);
        }
        return nodes;
    }

    const typeDetect = (per) => {
        if(typeof per == 'function'){
            return typeof per;
        }
        if(typeof per == 'boolean'){
            return typeof per;
        }
        if(typeof per == 'string'){
            return typeof per;
        }
        if(typeof per == 'number'){
            return typeof per;
        }
        if(typeof per == 'object'){
            if(Array.isArray(per)){
                return 'array';
            }else{
                return 'object';
            }
        }
    };

    const getLastStandarElement = (elements, classNames = [], content = '') => {
        let lastElement = elements[elements.length - 1];
        lastElement.innerHTML = content;
        classNames.forEach(item => lastElement.classList.add(item));
        return lastElement;
    }

    function clearRoundRect(ctx, x, y, width, height, radius) {
        if (width < 2 * radius) radius = width / 2;
        if (height < 2 * radius) radius = height / 2;
        ctx.save();
        ctx.beginPath();
        ctx.moveTo(x + radius, y);
        ctx.arcTo(x + width, y, x + width, y + height, radius);
        ctx.arcTo(x + width, y + height, x, y + height, radius);
        ctx.arcTo(x, y + height, x, y, radius);
        ctx.arcTo(x, y, x + width, y, radius);
        ctx.closePath();
        ctx.clip();
        ctx.clearRect(x - 2, y - 2, width + 4, height + 4);
        ctx.restore();
    }

    const saveState = state => {
        w.localStorage.setItem('SkyGuide', JSON.stringify(state));
    }

    const getState = () => {
        let skyGuideState = w.localStorage.getItem('SkyGuide');
        return skyGuideState != null ? JSON.parse(skyGuideState) : null;
    }

    const destroyState = () => {
        w.localStorage.removeItem('SkyGuide');
    }

    w.SkyGuide = (options = null) => {
        let step,   // 1 - 2 - 3 - 4
            event,  // create || start
            view,
            data = {};

        // Set dinamic variables
        let savePar = [];

        const separator = 15;
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

        // Create Canvas
        let sgCanvas = d.getElementById('SkyGuide-overlay');
        if (!sgCanvas) {
            sgCanvas = d.createElement('canvas');
            sgCanvas.id = 'SkyGuide-overlay';
            d.body.appendChild(sgCanvas);
        }
        let ctx = sgCanvas.getContext("2d");

        const setCanvasSize = () => {
            sgCanvas.height = w.innerHeight;
            sgCanvas.width = w.innerWidth;
        }

        const clearCanvas = () => {
            ctx.clearRect(0, 0, sgCanvas.width, sgCanvas.height);
            ctx.fillStyle = 'rgba(0,0,0,.5)';
            ctx.fillRect(0, 0, sgCanvas.width, sgCanvas.height);
        }
        setCanvasSize();
        clearCanvas();
        d.body.classList.add('SkyGuide-show');

        let sgModalPos = d.createElement('div');
        sgModalPos.classList.add('SkyGuide-wrapper');


        d.body.appendChild(sgModalPos);

        sgModalPos.innerHTML = SkyGuideTemplate;
        let sgModalCover = getLastStandarElement(getElementByContent(sgModalPos, '{{modal-cover}}'), ['sgModal-cover'], '');
        let sgModalTitle = getLastStandarElement(getElementByContent(sgModalPos, '{{modal-title}}'), ['sgModal-title'], '');
        let sgModalMap = getLastStandarElement(getElementByContent(sgModalPos, '{{modal-map}}'), ['sgModal-map'], SkyGuideLang.tourMapText);
        let sgModalClose = getLastStandarElement(getElementByContent(sgModalPos, '{{modal-close}}'), ['sgModal-close'], SkyGuideLang.cancelText);

        let sgModalHeader = getLastStandarElement(getElementByContent(sgModalPos, '{{modal-header}}'), ['sgModal-header'], '');
        let sgModalBody = getLastStandarElement(getElementByContent(sgModalPos, '{{modal-body}}'), ['sgModal-body'], '');

        let sgModalValue = getLastStandarElement(getElementByContent(sgModalPos, '{{step-value}}'), ['sgModal-value'], '');
        let sgModalTotal = getLastStandarElement(getElementByContent(sgModalPos, '{{step-total}}'), ['sgModal-total'], '');

        let sgModalPrev = getLastStandarElement(getElementByContent(sgModalPos, '{{modal-prev}}'), ['sgModal-prev'], SkyGuideLang.prevTextDefault);
        let sgModalNext = getLastStandarElement(getElementByContent(sgModalPos, '{{modal-next}}'), ['sgModal-next'], SkyGuideLang.nextTextDefault);

        let sgModalCancel = getLastStandarElement(getElementByContent(sgModalPos, '{{modal-cancel}}'), ['sgModal-cancel'], SkyGuideLang.introDialogBtnCancel);
        let sgModalStart = getLastStandarElement(getElementByContent(sgModalPos, '{{modal-start}}'), ['sgModal-start'], SkyGuideLang.introDialogBtnStart);

        let sgModalFirst = getLastStandarElement(getElementByContent(sgModalPos, '{{modal-first}}'), ['sgModal-first'], SkyGuideLang.contDialogBtnBegin);
        let sgModalContinue = getLastStandarElement(getElementByContent(sgModalPos, '{{modal-continue}}'), ['sgModal-continue'], SkyGuideLang.contDialogBtnContinue);


        const drawOverlay = (currentView) => {
            setCanvasSize();
            clearCanvas();

            if (currentView.target) {
                let targets = currentView.target.replace(' ', '').split(',');
                d.body.classList.add('SkyGuide-event');

                targets.forEach(item => {
                    let targetElement = d.querySelector(item);
                    if (targetElement) {

                        targetElement.classList.add('SkyGuide-highlight');
                        let positionInfo = targetElement.getBoundingClientRect();

                        let newPosX, newPosY, newW, newH;
                        newPosX = positionInfo.x - data.spacing;
                        newPosY = positionInfo.y - data.spacing;
                        newW = positionInfo.width + (data.spacing * 2);
                        newH = positionInfo.height + (data.spacing * 2);
                        clearRoundRect(ctx, newPosX, newPosY, newW, newH, 4);

                        if (currentView.event) {
                            let eventType = typeDetect(currentView.event);
                            let elementListening = null;
                            if (eventType === 'string')
                                elementListening = targetElement;
                            else if (eventType === 'array')
                                elementListening = document.querySelector(currentView.event[1]);
                            const triggerEvent = e => {
                                console.log('como', e);
                            };
                            if (elementListening){
                                elementListening.removeEventListener(currentView.trigger, triggerEvent);
                                elementListening.addEventListener(currentView.trigger, triggerEvent);
                            }
                        }
                    }
                })
            }
        };

        const setPositionModal = currentView => {
            let guideInfo = sgModalPos.getBoundingClientRect();

            const setCenterView = () => {
                let newPosX = (w.innerWidth / 2) - (guideInfo.width / 2);
                let newPosY = (w.innerHeight / 2) - (guideInfo.height / 2);

                sgModalPos.style.top = `${newPosY}px`;
                sgModalPos.style.left = `${newPosX}px`;
            }

            if (currentView.target) {
                let target = currentView.target.replace(' ', '').split(',')[0];
                let targetElement = d.querySelector(target);
                if (targetElement) {
                    let positionInfo = targetElement.getBoundingClientRect();

                    let newPosX = positionInfo.x + positionInfo.width + data.spacing + separator;
                    let newPosY = positionInfo.y - data.spacing;

                    if (guideInfo.width > (w.innerWidth - newPosX)) {
                        newPosX = positionInfo.x - data.spacing;
                        newPosY = positionInfo.y + positionInfo.height + data.spacing + separator;
                        if (guideInfo.width > (w.innerWidth - newPosX)) {
                            newPosX = positionInfo.x - guideInfo.width + positionInfo.width + data.spacing;
                        }
                    }

                    if (guideInfo.height > (w.innerHeight - newPosY)) {
                        newPosY = positionInfo.y - guideInfo.height - data.spacing - separator;
                    }

                    sgModalPos.style.top = `${newPosY}px`;
                    sgModalPos.style.left = `${newPosX}px`;
                } else {
                    setCenterView();
                }
            } else {
                setCenterView();
            }
        }

        const PaintSkyGuideModal = (currentView, step, total) => {
            let targetLoc = location.href;
            if (currentView.loc) {
                if (targetLoc != currentView.loc) {
                    saveState({
                        step,
                        event,
                        data,
                    });
                    w.location.href = currentView.loc;
                    return;
                }
            }

            view = currentView;
            if (step === -1) {
                sgModalHeader.innerHTML = '';
                sgModalBody.innerHTML = '';
            } else {
                sgModalHeader.innerHTML = currentView.title || '';
                sgModalBody.innerHTML = currentView.content || '';

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
                    sgModalPrev.textContent = currentView.prevText || SkyGuideLang.prevTextDefault;
                    sgModalNext.textContent = currentView.nextText || SkyGuideLang.nextTextDefault;

                    if (step >= total) {
                        sgModalNext.textContent = SkyGuideLang.endText;
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

            drawOverlay(currentView);
            setPositionModal(currentView);
        }

        const listenerScrollW = () => {
            if (view) {
                setPositionModal(view);
                drawOverlay(view);
            }
        }

        const listenerResizeW = () => {
            if (view) {
                setPositionModal(view);
                drawOverlay(view);
            }
        }

        const destroyGuide = () => {
            d.body.classList.remove('SkyGuide-show');
            d.body.classList.remove('SkyGuide-event');
            sgCanvas.remove();
            sgModalPos.remove();
            destroyState();
        }

        function handleStart() {
            step = 1;
            PaintSkyGuideModal({
                ...data.steps[step - 1],
            }, step, data.steps.length);
        };

        function handleCancel() {
            destroyGuide();
        };

        function handleContinue() {
            //console.log('handleContinue');
        };

        function handleFirst() {
            step = 1;
            PaintSkyGuideModal({
                ...data.steps[step - 1],
            }, step, data.steps.length);
        };

        function handlePrev() {
            step = step - 1;
            PaintSkyGuideModal({
                ...data.steps[step - 1],
            }, step, data.steps.length);
        };

        function handleNext(e = null) {
            console.log('handleNext');
            if (data.steps.length == step) {
                step = 0;
                destroyGuide();
            } else {
                step = step + 1;
                PaintSkyGuideModal({
                    ...data.steps[step - 1],
                }, step, data.steps.length);
            }
            if (e && e.target && e.target === sgModalNext) {
                let skLght = d.querySelectorAll('.SkyGuide-highlight');
                // skLght.forEach(item => {
                //     item.dispatchEvent(new Event('click'));
                // });
            }
        };


        if (step >= 1) {
            PaintSkyGuideModal({
                ...data.steps[step - 1],
            }, step, data.steps.length);
        } else {
            if (data.intro.enable) {
                PaintSkyGuideModal({
                    ...data.intro,
                }, 0, 0);
            } else {
                handleFirst();
            }
        }


        w.addEventListener('scroll', listenerScrollW);
        w.addEventListener('resize', listenerResizeW);

        sgModalClose.addEventListener('click', handleCancel);
        sgModalPrev.addEventListener('click', handlePrev);
        sgModalNext.addEventListener('click', handleNext);
        sgModalCancel.addEventListener('click', handleCancel);
        sgModalStart.addEventListener('click', handleStart);
        sgModalFirst.addEventListener('click', handleFirst);
        sgModalContinue.addEventListener('click', handleContinue);
    };

    d.addEventListener("DOMContentLoaded", () => {
        w.SkyGuide();
    });
})(window, document);
