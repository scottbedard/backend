/**
 * Set inner html and run scripts
 */
export function setInnerHTML(el: HTMLElement, html: string) {
  el.innerHTML = html;
  
  Array.from(el.querySelectorAll('script'))
    .forEach(oldScriptEl => {
      const newScriptEl = document.createElement("script");
      
      Array.from(oldScriptEl.attributes).forEach(attr => {
        newScriptEl.setAttribute(attr.name, attr.value) 
      });
      
      const scriptText = document.createTextNode(oldScriptEl.innerHTML)
      newScriptEl.appendChild(scriptText)
      
      oldScriptEl.parentNode?.replaceChild(newScriptEl, oldScriptEl)
  });
}