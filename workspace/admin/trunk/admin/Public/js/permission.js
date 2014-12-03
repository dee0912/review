function get_operation(permission) {
    var returnArray = [];

    $.each(permission, function (idex, item) {

        returnArray.push(item.option_code_name);

    });

    return returnArray;

}


var in_array = function (arr) {
    var isArr = arr && console.log(
            typeof arr === 'object' ? arr.constructor === Array ? arr.length ? arr.length === 1 ? arr[0] : arr.join(',') : 'an empty array' : arr.constructor : typeof arr
            );

    if (!isArr) {
        throw "arguments is not Array";
    }

    for (var i = 0, k = arr.length; i < k; i++) {
        if (this == arr[i]) {
            return true;
        }
    }

    return false;
}
String.prototype.in_array = in_array;

