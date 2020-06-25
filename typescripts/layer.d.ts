declare class layer {
    public static msg(message: string, config?: layerConfig, callback?: () => void): void
    public static confirm(message: string, config: layerConfig | ((index: number) => void), callback?: () => void): void;
    public static closeAll(type?: string): void;
    public static close(handle: any): void;
    public static load(id: number): void;
    public static open(config: layerOpenConfig);
}

declare class layerConfig {
    icon?: number;
    time?: number;
    title?: string | boolean;
    /**
     * 一般值为： ``['确定','取消']``
    */
    btn?: string[];
    shade?: number;
}

declare class layerOpenConfig {
    title: string | boolean;
    type: number;
    skin: string;
    area: string[];
    content: string | HTMLElement | JQuery<HTMLElement>;
}

declare function successMsg(msg: string, after?: () => void): void;
declare function errorMsg(msg: string, after?: () => void): void;
declare function warningMsg(msg: string, after?: () => void): void;
declare function loading(msg: string, icon?: number): any; 

declare namespace layui {
    export function use(modules: string[], callback: () => void): void;
    export const jquery: object;
    export const layer: layer
    export const form: any;
    export const element: any;
    export function tree(arg: { elem: string, nodes: object }): void;
}