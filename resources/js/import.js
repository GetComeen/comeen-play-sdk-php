var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
const modules = [];
// export async function importComponent(componentName: string, name: string, url: string, timeout: number = 8000): Promise<ComponentOptions> {
//   return new Promise(async (resolve, reject) => {
//     const module: IModule = await importModule(componentName, name, url, timeout);
//     //@ts-ignore
//     const con = module.default;
//     console.log(con, name, window, modules)
//     let slideModule: SlideModule = new con(context);
//
//     // @ts-ignore
//     resolve(slideModule.component);
//   });
// }
export function importModule(componentName, name, url, timeout = 8000) {
    return __awaiter(this, void 0, void 0, function* () {
        return new Promise((resolve, reject) => {
            if (modules[name]) {
                resolve(modules[name]);
                return;
            }
            const script = document.createElement("script");
            const tempGlobal = "__tempModuleLoadingVariable" + Math.random().toString(32).substring(2);
            script.onload = function () {
                setTimeout(check, 200, 1);
                console.log("EXTERNAL SCRIPT LOADED");
            };
            script.src = url;
            document.head.appendChild(script);
            let maxTries = Math.round(timeout / 200);
            let check = function (tries) {
                console.log(componentName, window);
                if ((componentName in window)) {
                    let module = window[componentName];
                    console.log('RESOLVING COMPONENT MODULE', module, modules);
                    modules[name] = module;
                    resolve(module);
                    delete window[tempGlobal];
                    script.remove();
                }
                else {
                    if (tries >= maxTries && maxTries !== 0) {
                        console.log('STOP COMPONENT LOADING');
                        return;
                    }
                    setTimeout(check, 200, tries + 1);
                }
            };
        });
    });
}
export function importComponentOptions(componentName, name, url, timeout = 8000) {
    return __awaiter(this, void 0, void 0, function* () {
        return new Promise((resolve, reject) => {
            //
            // if (modules[componentName]) {
            //   resolve(modules[componentName]);
            //   return;
            // }
            if (modules[name]) {
                resolve(modules[name]);
                return;
            }
            const script = document.createElement("script");
            const tempGlobal = "__tempModuleLoadingVariable" + Math.random().toString(32).substring(2);
            script.onload = function () {
                setTimeout(check, 200, 1);
                console.log("EXTERNAL SCRIPT LOADED OPTIONS");
            };
            script.src = url;
            document.head.appendChild(script);
            let maxTries = Math.round(timeout / 200);
            let check = function (tries) {
                console.log(componentName, window);
                if ((componentName in window)) {
                    let module = window[componentName].default;
                    console.log('RESOLVING COMPONENT OPTIONS MODULE', module, modules);
                    modules[module.name] = module;
                    //@ts-ignore
                    resolve(module);
                    delete window[tempGlobal];
                    script.remove();
                }
                else {
                    if (tries >= maxTries && maxTries !== 0) {
                        console.log('STOP COMPONENT LOADING');
                        return;
                    }
                    setTimeout(check, 200, tries + 1);
                }
            };
        });
    });
}
//# sourceMappingURL=import.js.map