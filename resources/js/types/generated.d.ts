export type Application = {
name: string;
description: string;
type: string;
version: string;
channel: string;
api_level: string;
logo: string;
options: Record<string, any>[];
privileges: Privilege[];
modules: Module[];
id: number;
__exists: boolean;
};
export type Authorization = {
name: string;
api_token: string | null;
channel: string;
active: boolean;
applications: Application[];
id: number;
__exists: boolean;
};
export type Bundle = {
name: string;
description: string;
applications: Application[];
id: number;
__exists: boolean;
};
export type Module = {
identifier: string;
name: string;
description: string;
type: string;
logo: string;
options: Record<string, any>[];
application: Application;
id: number;
__exists: boolean;
};
export type Privilege = {
type: string;
options: Record<string, any>[];
why: string;
identifier: string;
id: number;
__exists: boolean;
};
export type User = {
user_name: string;
full_name: string;
email: string;
language: string;
id: number;
__exists: boolean;
};