
export default class Errors {
    constructor() {
        this.errors = {};
    }

    hasError(field) {
        return this.errors.hasOwnProperty(field);
    }

    recordErrors(errors) {
        this.errors = errors;
    }

    getErrorText(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    deleteError(field) {
        if (field) {
            delete this.errors[field];
        }
    }

    hasAnyErrors() {
        return Object.keys(this.errors).length > 0;
    }
}
