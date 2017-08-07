/* 
   +----------------------------------------------------------------------+
   | PHP Version 5                                                        |
   +----------------------------------------------------------------------+
   | Copyright (c) 1997-2008 The PHP Group                                |
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_01.txt                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Authors: Derick Rethans <derick@derickrethans.nl>                    |
   +----------------------------------------------------------------------+
*/

/* $Id$ */

#ifndef PHP_DBUS_H
#define PHP_DBUS_H

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "Zend/zend_hash.h"

#define PHP_DBUS_VERSION "0.1.0"

#ifndef PHP_FE_END
# define PHP_FE_END {NULL, NULL, NULL}
#endif

#ifndef ZEND_MOD_END
# define ZEND_MOD_END {NULL, NULL, NULL}
#endif

#if PHP_MINOR_VERSION > 3 || PHP_MAJOR_VERSION >= 7
# define DBUS_ZEND_OBJECT_PROPERTIES_INIT(_objPtr, _ce) \
    object_properties_init(&_objPtr->std, _ce); \
    if (!_objPtr->std.properties) { \
        rebuild_object_properties(&_objPtr->std); \
    };
#else
# define DBUS_ZEND_OBJECT_PROPERTIES_INIT(_objPtr, _ce) \
    zval *tmp; \
    zend_hash_copy(_objPtr->std.properties, &_ce->default_properties, \
                   (copy_ctor_func_t) zval_add_ref, (void *) &tmp, \
                   sizeof(zval *));
#endif

#if PHP_MAJOR_VERSION >= 7
typedef zend_object* zend_object_compat;

# define DBUS_ZEND_REGISTER_CLASS(_name, _parent) \
    do { \
        dbus_ce_##_name = zend_register_internal_class_ex(&ce_##_name, _parent); \
    } while(0)

# define DBUS_ZEND_OBJECT_ALLOC(_objPtr, _ce) \
    do { \
        _objPtr = ecalloc(1, sizeof(*_objPtr) + zend_object_properties_size(_ce)); \
        if (ptr) { \
            *ptr = _objPtr; \
        } \
    } while(0)

# define DBUS_ZEND_OBJECT_SET_HANDLERS(_objPtr, _objType) \
    do { \
        dbus_object_handlers_##_objType.offset = XtOffsetOf(php_##_objType##_obj, std); \
        dbus_object_handlers_##_objType.free_obj = \
            (zend_object_free_obj_t) dbus_object_free_storage_##_objType; \
        _objPtr->std.handlers = &dbus_object_handlers_##_objType; \
    } while(0)

# define DBUS_ZEND_OBJECT_INIT_RETURN(_objPtr, _ce, _objType) \
    do { \
        DBUS_ZEND_OBJECT_ALLOC(_objPtr, _ce); \
        zend_object_std_init(&_objPtr->std, _ce); \
        DBUS_ZEND_OBJECT_PROPERTIES_INIT(_objPtr, _ce); \
        DBUS_ZEND_OBJECT_SET_HANDLERS(_objPtr, _objType); \
        return &_objPtr->std; \
    } while(0)

# define DBUS_ZVAL_STRING(zv, str, af) \
    do { \
        ZVAL_STRING(zv, str); \
            if (0 == af) { \
            efree(str); \
        } \
    } while(0)

# define DBUS_ZEND_HASH_UPDATE(ht, key, zv) \
  zend_hash_update(ht, zend_string_init(key, sizeof(key)-1, 0), zv)

# define DBUS_ZEND_OBJ_STRUCT_DECL_BEGIN(_type) \
    typedef struct _##_type _type; \
    struct _##_type {

# define DBUS_ZEND_OBJ_STRUCT_DECL_END() \
        zend_object std; \
    }

#else
typedef zend_object_value zend_object_compat;

# define DBUS_ZEND_REGISTER_CLASS(_name, _parent) \
    do { \
        dbus_ce_##_name = zend_register_internal_class_ex(&ce_##_name, _parent, \
                                                          NULL TSRMLS_CC); \
    } while(0)

# define DBUS_ZEND_OBJECT_ALLOC(_objPtr, _ce) \
    do { \
        _objPtr = ecalloc(1, sizeof(*_objPtr)); \
        if (ptr) { \
            *ptr = _objPtr; \
        } \
    } while(0)

# define DBUS_ZEND_OBJECT_SET_HANDLERS(_objPtr, _objType) \
    do { \
        retval.handle = zend_objects_store_put(_objPtr, \
                (zend_objects_store_dtor_t) zend_objects_destroy_object, \
                (zend_objects_free_object_storage_t) dbus_object_free_storage_##_objType, \
                NULL TSRMLS_CC); \
        retval.handlers = &dbus_object_handlers_##_objType; \
    } while(0)

# define DBUS_ZEND_OBJECT_INIT_RETURN(_objPtr, _ce, _objType) \
    do { \
        zend_object_compat retval; \
        DBUS_ZEND_OBJECT_ALLOC(_objPtr, _ce); \
        zend_object_std_init(&_objPtr->std, _ce TSRMLS_CC); \
        DBUS_ZEND_OBJECT_PROPERTIES_INIT(_objPtr, _ce); \
        DBUS_ZEND_OBJECT_SET_HANDLERS(_objPtr, _objType); \
        return retval; \
    } while(0)

# define DBUS_ZVAL_STRING(zv, str, af) ZVAL_STRING(zv, str, af)

# define DBUS_ZEND_HASH_UPDATE(ht, key, zv) \
  zend_hash_update(ht, key, strlen(key), (void*)zv, sizeof(zval *), NULL)

# define DBUS_ZEND_OBJ_STRUCT_DECL_BEGIN(_type) \
    typedef struct _##_type _type; \
    struct _##_type { \
        zend_object std;

# define DBUS_ZEND_OBJ_STRUCT_DECL_END() \
    } \

#endif

extern zend_module_entry dbus_module_entry;
#define phpext_dbus_ptr &dbus_module_entry

PHP_METHOD(Dbus, __construct);
PHP_METHOD(Dbus, addWatch);
PHP_METHOD(Dbus, waitLoop);
PHP_METHOD(Dbus, requestName);
PHP_METHOD(Dbus, registerObject);
PHP_METHOD(Dbus, createProxy);

PHP_METHOD(DbusObject, __construct);
PHP_METHOD(DbusObject, __call);
PHP_METHOD(DbusSignal, __construct);
PHP_METHOD(DbusSignal, matches);
PHP_METHOD(DbusSignal, getData);
PHP_METHOD(DbusSignal, send);

PHP_METHOD(DbusArray, __construct);
PHP_METHOD(DbusArray, getData);
PHP_METHOD(DbusDict, __construct);
PHP_METHOD(DbusDict, getData);
PHP_METHOD(DbusVariant, __construct);
PHP_METHOD(DbusVariant, getData);
PHP_METHOD(DbusSet, __construct);
PHP_METHOD(DbusSet, getData);
PHP_METHOD(DbusStruct, __construct);
PHP_METHOD(DbusStruct, getData);
PHP_METHOD(DbusObjectPath, __construct);
PHP_METHOD(DbusObjectPath, getData);

#define PHP_DBUS_INT_WRAPPER_METHOD_DEF(t) \
	PHP_METHOD(Dbus##t, __construct);

PHP_DBUS_INT_WRAPPER_METHOD_DEF(Byte);
PHP_DBUS_INT_WRAPPER_METHOD_DEF(Bool);
PHP_DBUS_INT_WRAPPER_METHOD_DEF(Int16);
PHP_DBUS_INT_WRAPPER_METHOD_DEF(UInt16);
PHP_DBUS_INT_WRAPPER_METHOD_DEF(Int32);
PHP_DBUS_INT_WRAPPER_METHOD_DEF(UInt32);
PHP_DBUS_INT_WRAPPER_METHOD_DEF(Int64);
PHP_DBUS_INT_WRAPPER_METHOD_DEF(UInt64);
PHP_DBUS_INT_WRAPPER_METHOD_DEF(Double);

PHP_RINIT_FUNCTION(dbus);
PHP_RSHUTDOWN_FUNCTION(dbus);
PHP_MINIT_FUNCTION(dbus);
PHP_MSHUTDOWN_FUNCTION(dbus);
PHP_MINFO_FUNCTION(dbus);

ZEND_BEGIN_MODULE_GLOBALS(dbus)
ZEND_END_MODULE_GLOBALS(dbus)

#ifdef ZTS
#define DBUSG(v) TSRMG(dbus_globals_id, zend_dbus_globals *, v)
#else
#define DBUSG(v) (dbus_globals.v)
#endif

#endif /* PHP_DBUS_H */
