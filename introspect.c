#include "libxml/parser.h"
#include "libxml/parserInternals.h"

static xmlNode *php_dbus_find_element(xmlNode *element, char *name)
{
	if (!element) {
		return NULL;
	}
	do {
		if (element->type == XML_ELEMENT_NODE && strcmp(element->name, name) == 0) {
			return element;
		}
	} while((element = element->next));
	return NULL;
}

static xmlNode *php_dbus_find_element_by_attribute(xmlNode *element, char *name, char *attr, char *attr_value)
{
	if (!element) {
		return NULL;
	}
	do {
		if (element->type == XML_ELEMENT_NODE && strcmp(element->name, name) == 0) {
			xmlAttr *attrs = element->properties;

			do {
				if (attrs->type == XML_ATTRIBUTE_NODE && strcmp(attrs->name, attr) == 0 
					&& attrs->children->type == XML_TEXT_NODE 
					&& strcmp(attrs->children->content, attr_value) == 0) 
				{
					return element;
				}
			} while((attrs = attrs->next));
			return NULL;
		}
	} while((element = element->next));
	return NULL;
}

xmlNode *php_dbus_find_interface_node(xmlDocPtr doc, char *interface)
{
	xmlNode   *root, *interfaceNode, *children;
	root = php_dbus_find_element(doc->children, "node");

	if (!doc) {
		return NULL;
	}
	children = root->children;
	do {
		interfaceNode = php_dbus_find_element_by_attribute(children, "interface", "name", interface);
		if (interfaceNode) {
			return interfaceNode;
		}
	} while((children = children->next));
	return NULL;
}

xmlNode *php_dbus_find_method_node(xmlNode *root, char *method)
{
	xmlNode *methodNode;

	do {
		methodNode = php_dbus_find_element_by_attribute(root, "method", "name", method);
		if (methodNode) {
			return methodNode;
		}
	} while((root = root->next));
	return NULL;
}

xmlNode **php_dbus_get_next_sig(xmlNode **it, char **sig)
{
	do {
		if ((*it)->type == XML_ELEMENT_NODE && strcmp((*it)->name, "arg") == 0) {
			xmlAttr *attrs = (*it)->properties;
			int dirIn = 0, sigFound = 0;

			do {
				if (attrs->type == XML_ATTRIBUTE_NODE && strcmp(attrs->name, "type") == 0) {
					*sig = attrs->children->content;
					sigFound = 1;
				}
				if (attrs->type == XML_ATTRIBUTE_NODE && strcmp(attrs->name, "direction") == 0 && strcmp(attrs->children->content, "in") == 0) {
					dirIn = 1;
				}
			} while((attrs = attrs->next));
			if (sigFound && dirIn) {
				return &((*it)->next);
			}
			return NULL;
		}
	} while((it = &((*it)->next)));
	return NULL;
}
#if 0
int main(void)
{
	xmlParserCtxtPtr ctxt;
	xmlDocPtr  doc;
	xmlNode   *interfaceNode, *methodNode, *args, **it;
	int i = 0;
	char *sig;

	doc = xmlParseFile("examples/introspect.xml");
	interfaceNode = php_dbus_find_interface_node(doc, "org.freedesktop.Notifications");
	methodNode = php_dbus_find_method_node(interfaceNode->children, "Notify");

	it   = &methodNode->children;
	while (it = php_dbus_get_next_sig(it, &sig)) {
		printf("sig: '%s'\n", sig);
	}

	it   = &methodNode->children;
	while (it = php_dbus_get_next_sig(it, &sig)) {
		printf("sig: '%s'\n", sig);
	}
	xmlFreeDoc(doc);
}
#endif
