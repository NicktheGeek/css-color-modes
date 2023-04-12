import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";
import ServerSideRender from "@wordpress/server-side-render";

export default function Edit(props) {
  const blockProps = useBlockProps();
  return (
    <div {...blockProps}>
      <ServerSideRender
        block="thincrust/render-callback-example"
        attributes={props.attributes}
      />
    </div>
  );
}
