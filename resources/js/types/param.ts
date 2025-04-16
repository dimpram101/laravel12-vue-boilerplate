export type RouteParams = {
    "home": {};
    "password.confirm": {};
    "dashboard": {};
    "admin": {};
    "admin.users": {};
    "settings": {};
    "verification.send": {};
    "password.request": {};
    "password.email": {};
    "login": {};
    "logout": {};
    "register": {};
    "password.store": {};
    "password.reset": {
        token: string;
    };
    "appearance": {};
    "password.edit": {};
    "password.update": {};
    "profile.edit": {};
    "profile.update": {};
    "profile.destroy": {};
    "verification.notice": {};
    "verification.verify": {
        id: string;
        hash: string;
    };
};
