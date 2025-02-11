<?php

class GithubUpdater {
    private $slug;
    private $pluginData;
    private $username;
    private $repository;
    private $authorizeToken;
    private $githubAPIResult;

    public function __construct($pluginFile, $githubUsername, $githubRepository, $authorizeToken = '') {
        add_filter("pre_set_site_transient_update_plugins", array($this, "setTransitent"));
        add_filter("plugins_api", array($this, "setPluginInfo"), 10, 3);
        add_filter("upgrader_post_install", array($this, "postInstall"), 10, 3);

        $this->slug = plugin_basename($pluginFile);
        $this->username = $githubUsername;
        $this->repository = $githubRepository;
        $this->authorizeToken = $authorizeToken;
    }

    private function getRepositoryInfo() {
        if (empty($this->githubAPIResult)) {
            $url = "https://api.github.com/repos/{$this->username}/{$this->repository}/releases";
            if (!empty($this->authorizeToken)) {
                $url = add_query_arg(array('access_token' => $this->authorizeToken), $url);
            }

            $this->githubAPIResult = wp_remote_retrieve_body(wp_remote_get($url));
            if (!empty($this->githubAPIResult)) {
                $this->githubAPIResult = @json_decode($this->githubAPIResult);
            }

            if (is_array($this->githubAPIResult)) {
                $this->githubAPIResult = $this->githubAPIResult[0];
            }
        }
    }

    public function setTransitent($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }

        $this->getRepositoryInfo();

        $doUpdate = version_compare($this->githubAPIResult->tag_name, $transient->checked[$this->slug], 'gt');

        if ($doUpdate) {
            $package = $this->githubAPIResult->zipball_url;

            if (!empty($this->authorizeToken)) {
                $package = add_query_arg(array('access_token' => $this->authorizeToken), $package);
            }

            $obj = new stdClass();
            $obj->slug = $this->slug;
            $obj->new_version = $this->githubAPIResult->tag_name;
            $obj->url = $this->pluginData["PluginURI"];
            $obj->package = $package;
            $transient->response[$this->slug] = $obj;
        }

        return $transient;
    }

    public function setPluginInfo($false, $action, $response) {
        $this->getRepositoryInfo();

        if (empty($response->slug) || $response->slug != $this->slug) {
            return false;
        }

        $response->last_updated = $this->githubAPIResult->published_at;
        $response->slug = $this->slug;
        $response->plugin_name  = $this->pluginData["Name"];
        $response->version = $this->githubAPIResult->tag_name;
        $response->author = $this->pluginData["AuthorName"];
        $response->homepage = $this->pluginData["PluginURI"];
        $response->download_link = $this->githubAPIResult->zipball_url;

        return $response;
    }

    public function postInstall($true, $hook_extra, $result) {
        global $wp_filesystem;

        $pluginFolder = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . dirname($this->slug);
        $wp_filesystem->move($result['destination'], $pluginFolder);
        $result['destination'] = $pluginFolder;

        if ($this->pluginData["Name"]) {
            activate_plugin($this->slug);
        }

        return $result;
    }
}