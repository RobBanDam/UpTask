!function(){!async function(){try{const a="/api/tareas?id="+n(),o=await fetch(a),r=await o.json();e=r.tareas,t()}catch(e){console.log(e)}}();let e=[];function t(){if(function(){const e=document.querySelector("#listado-tareas");for(;e.firstChild;)e.removeChild(e.firstChild)}(),0===e.length){const e=document.querySelector("#listado-tareas"),t=document.createElement("LI");return t.textContent="No hay Tareas",t.classList.add("no-tareas"),void e.appendChild(t)}const o={0:"Pendiente",1:"Completa"};e.forEach(r=>{const c=document.createElement("LI");c.dataset.tareaId=r.id,c.classList.add("tarea");const d=document.createElement("P");d.textContent=r.nombre;const s=document.createElement("DIV");s.classList.add("opciones");const i=document.createElement("BUTTON");i.classList.add("estado-tarea"),i.classList.add(""+o[r.estado].toLowerCase()),i.textContent=o[r.estado],i.dataset.estadoTarea=r.estado,i.ondblclick=function(){!function(o){const r="1"===o.estado?"0":"1";o.estado=r,async function(o){const{estado:r,id:c,nombre:d,proyectoId:s}=o,i=new FormData;i.append("id",c),i.append("nombre",d),i.append("estado",r),i.append("proyectoId",n());try{const n="http://localhost:3000/api/tarea/actualizar",o=await fetch(n,{method:"POST",body:i}),d=await o.json();"exito"===d.respuesta.tipo&&(a(d.respuesta.mensaje,d.respuesta.tipo,document.querySelector(".contenedor-nueva-tarea")),e=e.map(e=>(e.id===c&&(e.estado=r),e)),t())}catch(e){console.log(e)}}(o)}({...r})};const l=document.createElement("BUTTON");l.classList.add("eliminar-tarea"),l.dataset.idTarea=r.id,l.textContent="Eliminar",l.ondblclick=function(){!function(a){Swal.fire({title:"¿Eliminar Tarea?",showCancelButton:!0,confirmButtonText:"Si",cancelButtonText:"No"}).then(o=>{o.isConfirmed&&async function(a){const{estado:o,id:r,nombre:c}=a,d=new FormData;d.append("id",r),d.append("nombre",c),d.append("estado",o),d.append("proyectoId",n());try{const n="http://localhost:3000/api/tarea/eliminar",o=await fetch(n,{method:"POST",body:d}),r=await o.json();r.resultado&&(Swal.fire("Eliminado!",r.mensaje,"success"),e=e.filter(e=>e.id!==a.id),t())}catch(e){console.log(e)}}(a)})}({...r})},s.appendChild(i),s.appendChild(l),c.appendChild(d),c.appendChild(s);document.querySelector("#listado-tareas").appendChild(c)})}function a(e,t,a){const n=document.querySelector(".alerta");n&&n.remove();const o=document.createElement("DIV");o.classList.add("alerta",t),o.textContent=e,a.parentElement.insertBefore(o,a.nextElementSibling),setTimeout(()=>{o.remove()},3e3)}function n(){const e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries()).id}document.querySelector("#agregar-tarea").addEventListener("click",(function(){const o=document.createElement("DIV");o.classList.add("modal"),o.innerHTML='\n            <form class="formulario nueva-tarea">\n                <legend>Añade una Nueva Tarea</legend>\n                <div class="campo">\n                    <label>Tarea</label>\n                    <input \n                        type="text"\n                        name="tarea"\n                        placeholder="Añadir Tarea al Proyecto Actual"\n                        id="tarea"\n                    />\n                </div>\n                <div class="opciones">\n                    <input type="submit" class="submit-nueva-tarea" value="Añadir Tarea" />\n                    <button type="button" class="cerrar-modal">Cancelar</button>\n                </div>\n            </form>\n            ',setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),o.addEventListener("click",(function(r){if(r.preventDefault(),r.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{o.remove()},500)}r.target.classList.contains("submit-nueva-tarea")&&function(){const o=document.querySelector("#tarea").value.trim();if(""===o)return void a("El Nombre de la Tarea es Obligatoria","error",document.querySelector(".formulario legend"));!async function(o){const r=new FormData;r.append("nombre",o),r.append("proyectoId",n());try{const n="http://localhost:3000/api/tarea",c=await fetch(n,{method:"POST",body:r}),d=await c.json();if(a(d.mensaje,d.tipo,document.querySelector(".formulario legend")),"exito"===d.tipo){const a=document.querySelector(".modal");setTimeout(()=>{a.remove()},3e3);const n={id:String(d.id),nombre:o,estado:"0",proyectoId:d.proyectoId};e=[...e,n],t()}}catch(e){console.log(e)}}(o)}()})),document.querySelector(".dashboard").appendChild(o)}))}();