import { registerPlugin } from "@wordpress/plugins";
import { PluginDocumentSettingPanel } from "@wordpress/edit-post";
import { ToggleControl } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { useEntityProp } from "@wordpress/core-data";

registerPlugin("thincrust-page-style-panel", {
	render() {
		const meta_key = "thincrust_hide_title";

		const postType = useSelect(
			(select) => select("core/editor").getCurrentPostType(),
			[]
		);
		const [meta, setMeta] = useEntityProp("postType", postType, "meta");
		if ("page" !== postType) {
			return <div />;
		}
		const thincrust_hide_title = meta[meta_key];

		const updateMetaValue = (newValue) => {
			console.log(newValue);
			setMeta({ ...meta, thincrust_hide_title: newValue });
		};
		return (
			<PluginDocumentSettingPanel
				name="thincrust-page-style"
				title="Page Style"
				className="thincrust-page-style"
			>
				<ToggleControl
					label="Hide Page Title"
					checked={thincrust_hide_title}
					onChange={(state) => {
						updateMetaValue(state);
					}}
				/>
			</PluginDocumentSettingPanel>
		);
	},
	icon: "admin-appearance",
});
